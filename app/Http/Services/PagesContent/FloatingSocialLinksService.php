<?php

namespace App\Http\Services\PagesContent;

use App\Models\FloatingSocialLink;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class FloatingSocialLinksService{

    use ResponsesTrait;
    use FileUploadTrait;

    public function get(){

        return FloatingSocialLink::get();
    }

    public function getById($id){

        $floatingSocialLink = FloatingSocialLink::find($id);
        if($floatingSocialLink == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $floatingSocialLink;
    }

    public function create($floatingSocialLink){

        try{

            $createdFloatingSocialLink = FloatingSocialLink::create($floatingSocialLink);

            return $createdFloatingSocialLink;
        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function update($newFloatingSocialLink){

        $floatingSocialLink = $this->getById($newFloatingSocialLink['id']);
        try{

            $floatingSocialLink->update($newFloatingSocialLink);
            return $floatingSocialLink;

        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id){

        $floatingSocialLink = $this->getById($id);

        try{

            $imgPath = $floatingSocialLink->img_path;
            $floatingSocialLink->delete();
            $this->deleteFile($imgPath);


        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }



}
