<?php

namespace App\Http\Controllers\PagesContent;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Http\Requests\FrequentlyAskedQuestion\StoreRequest;
use App\Http\Requests\FrequentlyAskedQuestion\UpdateRequest;
use App\Http\Services\PagesContent\FrequentlyAskedQuestionsService;

class FrequentlyAskedQuestionsController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;
    private $frequentlyAskedQuestionsService;

    public function __construct()
    {

        $this->frequentlyAskedQuestionsService = new FrequentlyAskedQuestionsService();
    }


    public function get(){


        $frequentlyAskedQuestions = $this->frequentlyAskedQuestionsService->get();
        return $this->apiResponse($frequentlyAskedQuestions );
    }

    public function create(StoreRequest $request)
    {

        $frequentlyAskedQuestion = $request->validated();

        $this->frequentlyAskedQuestionsService->create($frequentlyAskedQuestion);

        return $this->apiResponse();
    }



    public function update(UpdateRequest $request)
    {

        $frequentlyAskedQuestion = $request->validated();

        $this->frequentlyAskedQuestionsService->update($frequentlyAskedQuestion);

        return $this->apiResponse();

    }

    public function delete($id)
    {

        $this->frequentlyAskedQuestionsService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }



}
