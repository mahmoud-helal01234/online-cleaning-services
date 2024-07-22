<?php

namespace App\Http\Services\PagesContent;

use App\Models\CooperationWithUsReason;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class CooperationWithUsReasonsService{

    use ResponsesTrait;
    use FileUploadTrait;

    public function get(){

        return CooperationWithUsReason::get();
    }

    public function getById($id){

        $cooperationWithUsReason = CooperationWithUsReason::find($id);
        if($cooperationWithUsReason == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $cooperationWithUsReason;
    }

    public function create($cooperationWithUsReason){

        try{
            $createdCooperationWithUsReason = CooperationWithUsReason::create($cooperationWithUsReason);
            return $createdCooperationWithUsReason;
        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function toggleActivation($id, $activationStatus){

        $cooperationWithUsReason = $this->getById($id);
        try{

            $cooperationWithUsReason->update(['active' => $activationStatus]);


        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function update($newCooperationWithUsReason){
        $cooperationWithUsReason = $this->getById($newCooperationWithUsReason['id']);

        try{
            $cooperationWithUsReason->update($newCooperationWithUsReason);
            return $cooperationWithUsReason;

        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id){

        $cooperationWithUsReason = $this->getById($id);

        try{

            $imgPath = $cooperationWithUsReason->img_path;
            $cooperationWithUsReason->delete();

            $this->deleteFile($imgPath);


        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }



}
