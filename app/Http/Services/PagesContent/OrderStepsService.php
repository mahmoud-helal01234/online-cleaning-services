<?php

namespace App\Http\Services\PagesContent;

use App\Models\OrderStep;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderStepsService{

    use ResponsesTrait;
    use FileUploadTrait;

    public function get(){

        return OrderStep::get();
    }

    public function getById($id){

        $orderStep = OrderStep::find($id);
        if($orderStep == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $orderStep;
    }

    public function create($orderStep){

        try{
            $createdOrderStep = OrderStep::create($orderStep);
            return $createdOrderStep;
        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function update($newOrderStep){

        $orderStep = $this->getById($newOrderStep['id']);
        try{
            $orderStep->update($newOrderStep);
            return $orderStep;

        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function toggleActivation($id, $activationStatus)
    {

        $orderStep = $this->getById($id);
        try {

            $orderStep->update(['active' => $activationStatus]);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id){

        $orderStep = $this->getById($id);

        try{

            $imgPath = $orderStep->img_path;
            $orderStep->delete();
            $this->deleteFile($imgPath);


        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }



}
