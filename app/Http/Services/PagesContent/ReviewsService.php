<?php

namespace App\Http\Services\PagesContent;

use App\Models\Review;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReviewsService{

    use ResponsesTrait;
    use FileUploadTrait;

    public function get(){

        return Review::get();
    }

    public function getById($id){

        $review = Review::find($id);
        if($review == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $review;
    }

    public function create($review){

        try{

            $createdReview = Review::create($review);

            return $createdReview;
        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function update($newReview){

        $review = $this->getById($newReview['id']);
        try{

            $review->update($newReview);
            return $review;

        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id){

        $review = $this->getById($id);

        try{

            $imgPath = $review->img_path;
            $review->delete();
            $this->deleteFile($imgPath);


        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }



}
