<?php

namespace App\Http\Services\PagesContent;

use App\Models\StatisticsTag;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class StatisticsTagsService{

    use ResponsesTrait;
    use FileUploadTrait;

    public function get(){

        return StatisticsTag::get();
    }

    public function getById($id){

        $statisticsTag = StatisticsTag::find($id);
        if($statisticsTag == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $statisticsTag;
    }

    public function create($statisticsTag){

        try{
            $createdStatisticsTag = StatisticsTag::create($statisticsTag);
            return $createdStatisticsTag;
        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function update($newStatisticsTag){

        $statisticsTag = $this->getById($newStatisticsTag['id']);
        try{
            $statisticsTag->update($newStatisticsTag);
            return $statisticsTag;

        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id){

        $statisticsTag = $this->getById($id);

        try{

            $imgPath = $statisticsTag->img_path;
            $statisticsTag->delete();
            $this->deleteFile($imgPath);


        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }



}
