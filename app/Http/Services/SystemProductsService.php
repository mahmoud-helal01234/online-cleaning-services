<?php

namespace App\Http\Services;

use App\Models\SystemProduct;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class SystemProductsService
{

    use ResponsesTrait;
    use FileUploadTrait;

    public function get()
    {

        $systemProducts = SystemProduct::with('options')->with('category')->get();
        return $systemProducts;
    }

    public function getForCompanyAndCategory($categoryId)
    {

        $systemProducts = SystemProduct::with('options')->where('category_id', $categoryId)->get();
        return $systemProducts;
    }

    public function getById($id)
    {

        $systemProduct = SystemProduct::find($id);

        if ($systemProduct == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));

        return $systemProduct;
    }

    public function create($systemProduct)
    {

        try {

            $createdSystemProduct = SystemProduct::create($systemProduct);
            return $createdSystemProduct;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function update($newSystemProduct)
    {

        $systemProduct = $this->getById($newSystemProduct['id']);
        try {

            $systemProduct->update($newSystemProduct);
            return $systemProduct;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id)
    {

        $systemProduct = $this->getById($id);

        try {

            $imgPath = $systemProduct->img_path;
            $systemProduct->delete();
            $this->deleteFile($imgPath);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }
}
