<?php

namespace App\Http\Controllers\PagesContent;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\OffersPageContent\UpdateRequest;
use App\Http\Services\PagesContent\OffersPageContentService;

class OffersPageContentController extends Controller
{

    use ResponsesTrait;
    private $offersPageContentService;

    public function __construct()
    {

        $this->offersPageContentService = new OffersPageContentService();
    }

    public function get()
    {

        $offersPageContent = $this->offersPageContentService->get();
        return $this->apiResponse($offersPageContent);
    }

    public function update(UpdateRequest $request)
    {

        $offersPageContent = $request->validated();
        $this->offersPageContentService->update($offersPageContent);
        return $this->apiResponse();
    }

}
