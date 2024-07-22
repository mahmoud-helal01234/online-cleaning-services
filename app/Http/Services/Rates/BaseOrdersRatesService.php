<?php

namespace App\Http\Services\Rates;

use App\Models\BaseOrdersRate;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseOrdersRatesService
{

    use ResponsesTrait;
    use FileUploadTrait;

    public function get()
    {

        $baseOrdersRates = BaseOrdersRate::get();

        return $baseOrdersRates;
    }

    public function getById($id)
    {

        $baseOrdersRate = BaseOrdersRate::find($id);

        if ($baseOrdersRate == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));

        return $baseOrdersRate;
    }

    public function create($baseOrdersRate)
    {

        try {

            BaseOrdersRate::create($baseOrdersRate);
            ;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function update($newBaseOrdersRate)
    {

        $baseOrdersRate = $this->getById($newBaseOrdersRate['id']);
        try {

            $baseOrdersRate->update($newBaseOrdersRate);
            return $baseOrdersRate;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id)
    {

        $baseOrdersRate = $this->getById($id);

        try {

            $baseOrdersRate->delete();
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }
}
