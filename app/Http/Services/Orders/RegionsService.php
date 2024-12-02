<?php

namespace App\Http\Services\Orders;

use App\Models\Region;
use App\Http\Traits\ResponsesTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegionsService
{

    use ResponsesTrait;

    public function get()
    {

        $regions = Region::get();
        return $regions;
    }

    public function getById($id)
    {

        $region = Region::find($id);
        if ($region == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));

        return $region;
    }

    public function create($region)
    {

        try {

            $createdRegion = Region::create($region);
            return $createdRegion;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }

    public function update($newRegion)
    {

        $region = $this->getById($newRegion['id']);
        try {

            $region->update($newRegion);
            return $region;

        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }

    public function toggleActivation($id, $activationStatus)
    {

        $region = $this->getById($id);
        try {

            $region->update(['active' => $activationStatus]);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }

    public function delete($id)
    {

        $region = $this->getById($id);

        try {

            $region->delete();
            
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }
}
