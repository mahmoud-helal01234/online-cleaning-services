<?php

namespace App\Http\Controllers\Offers;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Services\Offers\OffersService;
use App\Http\Requests\Offer\StoreRequest;
use App\Http\Requests\Offer\UpdateRequest;
use App\Http\Controllers\Controller;

class OffersController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;
    private $offersService;

    public function __construct()
    {

        $this->offersService = new OffersService();
    }

    public function get()
    {

        $offers = $this->offersService->get();
        return $this->apiResponse($offers);
    }


    public function create(StoreRequest $request)
    {

        $data = $request->validated();
        $this->offersService->create($data);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request)
    {
        $offer = $request->validated();
        $this->offersService->update($offer);
        return $this->apiResponse();
    }

    public function toggleActivation($id, $activationStatus)
    {

        $this->offersService->toggleActivation($id, $activationStatus);
        return $this->apiResponse();
    }

    public function delete($id)
    {

        $this->offersService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }

}
