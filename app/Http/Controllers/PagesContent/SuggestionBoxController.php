<?php

namespace App\Http\Controllers\PagesContent;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Http\Services\PagesContent\SuggestionBoxService;
use App\Http\Requests\SuggestionBox\StoreRequest;

class SuggestionBoxController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;
    private $suggestionBoxService;

    public function __construct()
    {

        $this->suggestionBoxService = new SuggestionBoxService();
    }


    public function get(){


        $suggestionBox = $this->suggestionBoxService->get();
        return $this->apiResponse($suggestionBox );
    }

    public function create(StoreRequest $request)
    {

        $suggestionBox = $request->validated();

        $this->suggestionBoxService->create($suggestionBox);

        return $this->apiResponse();
    }

    public function delete($id)
    {

        $this->suggestionBoxService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }

}
