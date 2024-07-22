<?php

namespace App\Http\Controllers\DriversApp;


use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Http\Services\DriversApp\ProductsService;
use App\Http\Requests\DriversApp\Product\StoreRequest;
use App\Http\Requests\DriversApp\Product\UpdateRequest;

class ProductsController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;

    private $productsService;
    public function __construct()
    {

        $this->productsService = new ProductsService();
    }



    public function copyProductsToUser($fromId,$toId){

        $this->productsService->copyProductsToUser($fromId,$toId);
        return $this->apiResponse();
    }


    public function get()
    {

        $products = $this->productsService->get();
        return $this->apiResponse($products);
    }

    public function create(StoreRequest $request)
    {

        $product = $request->validated();
        $this->productsService->create($product);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request)
    {

        $product = $request->validated();
        $this->productsService->update($product);
        return $this->apiResponse();
    }

    public function delete($id)
    {

        $this->productsService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }

}


