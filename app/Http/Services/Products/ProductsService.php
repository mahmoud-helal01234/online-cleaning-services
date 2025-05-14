<?php

namespace App\Http\Services\Products;

use App\Models\Product;
use App\Http\Traits\ResponsesTrait;
use App\Models\CompaniesCategories;
use App\Http\Traits\FileUploadTrait;
use App\Http\Traits\LoggedInUserTrait;
use App\Http\Services\Products\ProductOptionsService;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductsService
{

    use ResponsesTrait;
    use FileUploadTrait;
    use LoggedInUserTrait;

    public function get($mainCategoryIds = null, $categoryIds = null)
    {

        // $loggedInUser = $this->getLoggedInUser();

        $products = Product::with('options.option')
            ->when($categoryIds != null, function ($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds);
            })->when($mainCategoryIds != null, function ($query) use ($mainCategoryIds) {
            $query->whereHas('category', function ($q) use ($mainCategoryIds) {
                $q->whereIn('main_category_id', $mainCategoryIds);
            });
        })
        ->get();

        return $products;
        // return ProductsResource::collection($products);
    }

    public function getById($id)
    {

        $product = Product::where('id', $id)->with('options.option')->first();

        if ($product == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));

        return $product;
    }

    public function create($product)
    {

        try {
            $user = $this->getLoggedInUser();

            $createdProduct = Product::create($product);
            $productOptionsService = new ProductOptionsService();

            foreach ($product['options'] as $productOption) {

                $productOptionsService->create([...$productOption, "product_id" => $createdProduct->id]);
            }
            
            return $this->getById($createdProduct->id);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }

    public function update($newProduct)
    {

        $product = $this->getById($newProduct['id']);
        try {
            // CHECKED IN REQUEST AUTHORIZATION FOR WHO CAN UPDATE
            $updatedProduct = $product->update($newProduct);
            $productOptionsService = new ProductOptionsService();
            $productOptionsService->delete(productId: $newProduct['id']);

            foreach ($newProduct['options'] as $productOption) {

                $productOptionsService->create([...$productOption, "product_id" => $newProduct['id']]);
            }
            return $this->getById($newProduct['id']);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }

    public function toggleActivation($id, $activationStatus)
    {

        $product = $this->getById($id);
        try {

            $product->update(['active' => $activationStatus]);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));
        }
    }

    public function delete($id)
    {

        try {

            $this->deleteWithRelations($id);

        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        
        }
    }

    public function canUserUpdate($proudctId)
    {

        $proudct = $this->getById($proudctId);
        $user = $this->getLoggedInUser();
        // add country_manager case that he can only add or update only products belongs to company in the country that he manage
        switch ($user->role) {
            case "admin":
                return true;
            case "country_manager":
                return $proudct->company->country_id == $user->countryManager->country_id;
            case "company":
                return $proudct->company_id == $user->id;
        }
    }

    public function deleteWithRelations($id)
    {
        $product = $this->getById($id);

        $productOptionsService = new ProductOptionsService();
        $productOptionsService->delete(productId: $id);
        $product->delete();
    }
    public function deleteChildren($categoryId = null)
    {
        $categoryProudcts = Product::where('category_id', $categoryId)->get();
        $productOptionsService = new ProductOptionsService();

        foreach ($categoryProudcts as $categoryProudct) {
            $productOptionsService->delete(productId: $categoryProudct->id);
            $categoryProudct->delete();
        }
    }
}
