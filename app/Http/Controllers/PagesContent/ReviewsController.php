<?php

namespace App\Http\Controllers\PagesContent;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Http\Requests\Review\StoreRequest;
use App\Http\Requests\Review\UpdateRequest;
use App\Http\Services\PagesContent\ReviewsService;

class ReviewsController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;
    private $reviewsService;

    public function __construct()
    {

        $this->reviewsService = new ReviewsService();
    }


    public function get(){

        $reviews = $this->reviewsService->get();
        return $this->apiResponse($reviews );
    }

    public function create(StoreRequest $request)
    {

        $review = $request->validated();
        $createdReview = $this->reviewsService->create($review);
        return $this->apiResponse($createdReview);
    }

    public function update(UpdateRequest $request)
    {

        $review = $request->validated();

        $updatedReview = $this->reviewsService->update($review);

        return $this->apiResponse($updatedReview);

    }

    public function delete($id)
    {

        $this->reviewsService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }

}
