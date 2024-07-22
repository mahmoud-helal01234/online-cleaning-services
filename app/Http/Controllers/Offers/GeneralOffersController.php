<?php

namespace App\Http\Controllers\Offers;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Services\Offers\GeneralOffersService;
use App\Http\Requests\GeneralOffer\StoreRequest;
use App\Http\Requests\GeneralOffer\UpdateRequest;
use App\Http\Controllers\Controller;

class GeneralOffersController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;

    private $generalOffersService;
    public function __construct()
    {

        $this->generalOffersService = new GeneralOffersService();

    }

    public function get()
    {

        $generalOffers = $this->generalOffersService->get(request('active'));
        return $this->apiResponse($generalOffers);
    }

    public function create(StoreRequest $request)
    {

        $generalOffer = $request->validated();
        $this->generalOffersService->create($generalOffer);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request)
    {

        $generalOffer = $request->validated();
        $this->generalOffersService->update($generalOffer);
        return $this->apiResponse();
    }

    public function toggleActivation($id, $activationStatus)
    {

        $this->generalOffersService->toggleActivation($id, $activationStatus);
        return $this->apiResponse();
    }

    public function delete($id)
    {

        $this->generalOffersService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }



}


