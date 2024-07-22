<?php

namespace App\Http\Services\PagesContent;

use App\Models\AboutUsContent;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class AboutUsContentService {

    use ResponsesTrait;
    use FileUploadTrait;

    public function get(){

        $aboutUsContent = AboutUsContent::select('title_ar','title_en','content_ar','content_en'/*,'long','lat'*/)->first();

        return $aboutUsContent;
    }

    public function update($newAboutUsContent){

        try{

            $aboutUsContent = AboutUsContent::updateOrCreate(['id' => 1],$newAboutUsContent);
            return $aboutUsContent;
        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));
        }
    }

}
