<?php

namespace App\Http\Controllers\Offers;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Services\Offers\PromoCodeOffersService;
use App\Http\Requests\PromoCodeOffer\StoreRequest;
use App\Http\Requests\PromoCodeOffer\UpdateRequest;
use App\Http\Controllers\Controller;

class PromoCodeOffersController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;
    private $promoCodeOffersService;

    public function __construct()
    {

        $this->promoCodeOffersService = new PromoCodeOffersService();
    }

    public function get()
    {

        $promoCodeOffers = $this->promoCodeOffersService->get(promoCodeId:request('promo_code_id'),active:request('active'));
        return $this->apiResponse($promoCodeOffers);
    }
   

    public function create(StoreRequest $request)
    {

        $data = $request->validated();
        $this->promoCodeOffersService->create($data);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request)
    {

        $promoCodeOffer = $request->validated();
        $this->promoCodeOffersService->update($promoCodeOffer);
        return $this->apiResponse();
    }

    public function toggleActivation($id, $activationStatus)
    {

        $this->promoCodeOffersService->toggleActivation($id, $activationStatus);
        return $this->apiResponse();
    }

    public function delete($id)
    {

        $this->promoCodeOffersService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }

}
