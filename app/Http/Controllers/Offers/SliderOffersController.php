<?php

namespace App\Http\Controllers\Offers;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Http\Requests\SliderOffer\StoreRequest;
use App\Http\Requests\SliderOffer\UpdateRequest;
use App\Http\Services\PagesContent\SliderOffersService;

class SliderOffersController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;

    private $linkOffersService;
    public function __construct()
    {

        $this->linkOffersService = new SliderOffersService();

    }

    public function get()
    {

        $linkOffers = $this->linkOffersService->get(request('active'));
        return $this->apiResponse($linkOffers);
    }

    public function create(StoreRequest $request)
    {

        $linkOffer = $request->validated();
        $this->linkOffersService->create($linkOffer);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request)
    {

        $linkOffer = $request->validated();
        $this->linkOffersService->update($linkOffer);
        return $this->apiResponse();
    }
    public function toggleActivation($id, $activationStatus)
    {

        $this->linkOffersService->toggleActivation($id, $activationStatus);
        return $this->apiResponse();
    }

    public function delete($id)
    {

        $this->linkOffersService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }



}


