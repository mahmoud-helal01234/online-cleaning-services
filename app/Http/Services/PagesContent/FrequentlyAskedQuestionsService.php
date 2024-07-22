<?php

namespace App\Http\Services\PagesContent;

use App\Models\FrequentlyAskedQuestion;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class FrequentlyAskedQuestionsService{

    use ResponsesTrait;
    use FileUploadTrait;

    public function get(){

        return FrequentlyAskedQuestion::get();
    }

    public function getById($id){

        $frequentlyAskedQuestion = FrequentlyAskedQuestion::find($id);
        if($frequentlyAskedQuestion == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $frequentlyAskedQuestion;
    }

    public function create($frequentlyAskedQuestion){

        try{
            $createdFrequentlyAskedQuestion = FrequentlyAskedQuestion::create($frequentlyAskedQuestion);
            return $createdFrequentlyAskedQuestion;
        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function toggleActivation($id, $activationStatus){

        $frequentlyAskedQuestion = $this->getById($id);
        try{

            $frequentlyAskedQuestion->update(['active' => $activationStatus]);


        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function update($newFrequentlyAskedQuestion){
        $frequentlyAskedQuestion = $this->getById($newFrequentlyAskedQuestion['id']);

        try{
            $frequentlyAskedQuestion->update($newFrequentlyAskedQuestion);
            return $frequentlyAskedQuestion;

        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id){

        $frequentlyAskedQuestion = $this->getById($id);

        try{

            $imgPath = $frequentlyAskedQuestion->img_path;
            $frequentlyAskedQuestion->delete();

            $this->deleteFile($imgPath);


        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }



}
