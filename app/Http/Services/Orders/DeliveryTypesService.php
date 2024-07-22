<?php

namespace App\Http\Services\Orders;

use App\Models\DeliveryType;
use App\Http\Traits\ResponsesTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class DeliveryTypesService {

    use ResponsesTrait;

    public function get(){

        $deliveryTypes = DeliveryType::get();
        return $deliveryTypes;
    }

    public function getById($id){

        $deliveryType = DeliveryType::find($id);
        if($deliveryType == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));

        return $deliveryType;
    }

    public function create($deliveryType){

        try{

            $createdDeliveryType = DeliveryType::create($deliveryType);

        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function update($newDeliveryType){

        $deliveryType = $this->getById($newDeliveryType['id']);
        try{
            $deliveryType->update($newDeliveryType);

        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function toggleActivation($id, $activationStatus){

        $deliveryType = $this->getById($id);
        try{

            $deliveryType->update(['active' => $activationStatus]);

        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id){

        $deliveryType = $this->getById($id);

        try{

            $deliveryType->delete();
        } catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }

}
