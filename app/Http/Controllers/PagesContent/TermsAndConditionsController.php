<?php

namespace App\Http\Controllers\PagesContent;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\TermsAndConditions\UpdateRequest;
use App\Http\Services\PagesContent\TermsAndConditionsService;

class TermsAndConditionsController extends Controller
{

    use ResponsesTrait;
    private $termsAndConditionsService;

    public function __construct()
    {

        $this->termsAndConditionsService = new TermsAndConditionsService();
    }

    public function get()
    {

        $termsAndConditions = $this->termsAndConditionsService->get();
        return $this->apiResponse($termsAndConditions);
    }

    public function update(UpdateRequest $request)
    {

        $termsAndConditions = $request->validated();
        $this->termsAndConditionsService->update($termsAndConditions);
        return $this->apiResponse();
    }

}
