<?php

namespace App\Http\Services;

use App\Models\SystemProductOption;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class SystemProductOptionsService
{

    use ResponsesTrait;
    use FileUploadTrait;

    public function get($systemProductId = null)
    {

        $systemProducts = SystemProductOption::when($systemProductId != null, function ($query) use ($systemProductId) {

            $query->where('system_product_id', $systemProductId);
        })->get();

        return $systemProducts;
    }

    public function getById($id)
    {

        $systemProduct = SystemProductOption::find($id);

        if ($systemProduct == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));

        return $systemProduct;
    }

    public function create($systemProductOption)
    {

        try {

            $createdSystemProductOption = SystemProductOption::create($systemProductOption);
            return $createdSystemProductOption;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function update($newSystemProductOption)
    {

        $systemProductOption = $this->getById($newSystemProductOption['id']);
        try {

            $systemProductOption->update($newSystemProductOption);
            return $systemProductOption;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id)
    {

        $systemProductOption = $this->getById($id);

        try {

            $imgPath = $systemProductOption->img_path;
            $systemProductOption->delete();
            $this->deleteFile($imgPath);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }
}
