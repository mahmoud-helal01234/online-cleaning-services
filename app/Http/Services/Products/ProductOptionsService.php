<?php

namespace App\Http\Services\Products;

use App\Models\ProductOption;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductOptionsService
{

    use ResponsesTrait;
    use FileUploadTrait;

    public function get($productId = null)
    {

        $products = ProductOption::when($productId != null, function ($query) use ($productId) {

            $query->where('product_id', $productId);
        })->get();

        return $products;
    }

    public function getById($id)
    {

        $product = ProductOption::find($id);

        if ($product == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));

        return $product;
    }

    public function create($productOption)
    {

        try {
            $createdProductOption = ProductOption::create($productOption);
            return $createdProductOption;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }

    public function update($newProductOption)
    {

        $productOption = $this->getById($newProductOption['id']);
        try {

            $productOption->update($newProductOption);
            return $productOption;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }

    public function toggleActivation($id, $activationStatus)
    {

        $productOption = $this->getById($id);
        try {

            $productOption->update(['active' => $activationStatus]);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));
        }
    }

    public function delete($id = null, $productId = null)
    {

        if ($productId != null) {
            ProductOption::where('product_id', $productId)->delete();
            return;
        } else if ($id != null) {
            $productOption = $this->getById($id);

            try {

                $productOption->delete();
            } catch (\Exception $ex) {

                throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
            }
        }
    }
}
