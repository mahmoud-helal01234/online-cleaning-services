<?php

namespace App\Http\Controllers\Products;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Services\Products\ProductOptionsService;
use App\Http\Resources\ProductOptionsResource;
use App\Http\Requests\ProductOption\StoreRequest;
use App\Http\Requests\ProductOption\UpdateRequest;
use App\Http\Resources\ProductOptionsForProductResource;
use App\Http\Controllers\Controller;

class ProductOptionsController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;
    private $productOptionsService;

    public function __construct()
    {

        $this->productOptionsService = new ProductOptionsService();
    }

    public function get()
    {
        $productId = request('product_id');
        $products = $this->productOptionsService->get($productId);
        return $this->apiResponse($productId == null ? ProductOptionsResource::collection($products) : ProductOptionsForProductResource::collection($products));
    }

    public function create(StoreRequest $request)
    {

        $productOption = $request->validated();
        $this->productOptionsService->create($productOption);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request)
    {

        $productOption = $request->validated();
        $this->productOptionsService->update($productOption);
        return $this->apiResponse();
    }

    public function toggleActivation($id, $activationStatus)
    {

        $this->productOptionsService->toggleActivation($id, $activationStatus);
        return $this->apiResponse();
    }

    public function delete($id){

        $this->productOptionsService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }
}
