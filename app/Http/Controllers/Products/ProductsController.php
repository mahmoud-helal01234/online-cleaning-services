<?php

namespace App\Http\Controllers\Products;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Services\Products\ProductsService;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Controllers\Controller;

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

        $products = $this->productsService->get(categoryId:request('category_id'));
        return $this->apiResponse($products);
    }

    public function create(StoreRequest $request)
    {
        $data = $request->validated();
        $this->productsService->create($data);
        return $this->apiResponse();
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
