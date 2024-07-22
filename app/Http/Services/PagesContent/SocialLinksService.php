<?php

namespace App\Http\Services\PagesContent;

use App\Models\SocialLink;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class SocialLinksService{

    use ResponsesTrait;
    use FileUploadTrait;

    public function get(){

        return SocialLink::get();
    }

    public function getById($id){

        $socialLink = SocialLink::find($id);
        if($socialLink == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $socialLink;
    }

    public function create($socialLink){

        try{
            $createdSocialLink = SocialLink::create($socialLink);
            return $createdSocialLink;
        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function update($newSocialLink){

        $socialLink = $this->getById($newSocialLink['id']);
        try{

            $socialLink->update($newSocialLink);
            return $socialLink;

        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id){

        $socialLink = $this->getById($id);

        try{

            $imgPath = $socialLink->img_path;
            $socialLink->delete();
            $this->deleteFile($imgPath);


        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }



}
