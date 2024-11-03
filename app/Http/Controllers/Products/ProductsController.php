<?php

namespace App\Http\Controllers\Products;

use League\Csv\Reader;
use App\Models\Product;
use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Services\Products\ProductsService;
use App\Http\Services\Products\ProductOptionsService;
use Stichoza\GoogleTranslate\GoogleTranslate; // Import the translation library

class ProductsController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;
    private $productsService;

    public function __construct()
    {

        $this->productsService = new ProductsService();
    }

    public function get()
    {

        $products = $this->productsService->get(categoryId: request('category_id'));
        return $this->apiResponse($products);
    }

    public function create(StoreRequest $request)
    {
        $data = $request->validated();
        $this->productsService->create($data);
        return $this->apiResponse();
    }

    public function uploadImages(Request $request)
    {

        // Validate the incoming request to ensure files are provided
        // $request->validate([
        //     'images' => 'required|array',
        //     'images.*' => 'required|file|image', // Validate that each entry is a file and an image
        // ]);
        $file = $request->file('image'); // Get the uploaded files


        // Extract and trim the product name by removing the file extension
        // $productName = trim(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));

        // Search for the product by name
        $product = Product::where('id', request('id'))->first();

        if ($product) {
            // // Define the path where the images will be stored
            // $imagePath = 'images/' . $file->getClientOriginalName();

            // // Store the image in the 'public/images' directory
            // $file->storeAs('public/images', $file->getClientOriginalName());

            // Save the image path to the product
            $product->img_path = $file;
            $product->save();
        }
  

        return response()->json(['message' => 'Images processed successfully.'], 200);
    }



    public function import(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
            'category_id' => 'required|integer|exists:categories,id',
        ]);

        // Open and read the CSV file
        $csv = Reader::createFromPath($request->file('csv_file')->getRealPath());
        // $csv->setHeaderOffset(0); // Assuming the CSV has no header
        $translator = new GoogleTranslate('ar'); // 'ar' is for Arabic

        foreach ($csv as $record) {
            // Extract product name and option prices
            $productName = $record[0]; // Product name (name_en)
            $optionPrices = [
                'dry_clean' => $record[1], // Price for Dry clean
                'wash_iron' => $record[2], // Price for Wash & Iron
                'pressing' => $record[3],  // Price for Pressing
            ];
            try {
                $productNameArabic = $translator->translate($productName) ?? "";
            } catch (\Exception $e) {
                $productNameArabic = ""; // If translation fails, set as null
            }
            // Create the product
            $product = Product::create([
                'category_id' => request('category_id'),
                'name_ar' => $productNameArabic, // You will need to map Arabic name if available
                'name_en' => $productName,
            ]);

            if ($optionPrices['dry_clean'])

                if (!empty($optionPrices['dry_clean'])) {
                    $options[] = ['name_ar' => 'دري كلين', 'name_en' => 'Dry clean', 'price' => $optionPrices['dry_clean']];
                }

            if (!empty($optionPrices['wash_iron'])) {
                $options[] = ['name_ar' => 'غسيل و كوي', 'name_en' => 'Wash & Iron', 'price' => $optionPrices['wash_iron']];
            }

            if (!empty($optionPrices['pressing'])) {
                $options[] = ['name_ar' => 'كوي', 'name_en' => 'Pressing', 'price' => $optionPrices['pressing']];
            }


            $productOptionsService = new ProductOptionsService();

            foreach ($options as $option) {
                $productOptionsService->create([...$option, "product_id" => $product->id]);
            }
            $options = [];
        }

        return response()->json(['message' => 'Products imported successfully'], 201);
    }

    public function update(UpdateRequest $request)
    {

        $product = $request->validated();
        $this->productsService->update($product);
        return $this->apiResponse();
    }

    public function toggleActivation($id, $activationStatus)
    {

        $this->productsService->toggleActivation($id, $activationStatus);
        return $this->apiResponse();
    }

    public function delete($id)
    {

        $this->productsService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }
}
