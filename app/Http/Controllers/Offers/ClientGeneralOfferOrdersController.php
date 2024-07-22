<?php

namespace App\Http\Controllers\Offers;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Services\Offers\ClientGeneralOfferOrdersService;
use App\Http\Requests\ClientGeneralOfferOrder\StoreRequest;
use App\Http\Requests\ClientGeneralOfferOrder\UpdateRequest;
use App\Http\Controllers\Controller;

class ClientGeneralOfferOrdersController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;

    private $clientGeneralOfferOrdersService;
    public function __construct()
    {

        $this->clientGeneralOfferOrdersService = new ClientGeneralOfferOrdersService();

    }

    public function get()
    {

        $clientGeneralOfferOrders = $this->clientGeneralOfferOrdersService->get();
        return $this->apiResponse($clientGeneralOfferOrders);
    }

    public function create(StoreRequest $request)
    {

        $clientGeneralOfferOrder = $request->validated();
        $this->clientGeneralOfferOrdersService->create($clientGeneralOfferOrder);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request)
    {

        $clientGeneralOfferOrder = $request->validated();
        $this->clientGeneralOfferOrdersService->update($clientGeneralOfferOrder);
        return $this->apiResponse();
    }

    public function delete($id)
    {

        $this->clientGeneralOfferOrdersService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }



}


