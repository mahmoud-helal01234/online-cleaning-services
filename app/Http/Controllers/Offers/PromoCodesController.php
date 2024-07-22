<?php

namespace App\Http\Controllers\Offers;

use App\Http\Traits\ResponsesTrait;
use App\Http\Services\Offers\PromoCodesService;
use App\Http\Requests\PromoCode\StoreRequest;
use App\Http\Requests\PromoCode\UpdateRequest;
use App\Http\Requests\PromoCode\StorePromoCodeProductsRequest;
use App\Http\Requests\PromoCode\StorePromoCodeCompaniesRequest;
use App\Http\Requests\PromoCode\StorePromoCodeCountriesRequest;
use App\Http\Controllers\Controller;

class PromoCodesController extends Controller
{

    use ResponsesTrait;

    private $promoCodesService;

    public function __construct()
    {

        $this->promoCodesService = new PromoCodesService();
    }

    public function get($id = null)
    {

        $promoCodes = $this->promoCodesService->get($id,request('active'));
        return $this->apiResponse($promoCodes);
    }
    public function selectPromoCodes($companyId)
    {

        $promoCodes = $this->promoCodesService->selectPromoCodes($companyId);
        return $this->apiResponse($promoCodes);
    }

    public function create(StoreRequest $request)
    {

        $data = $request->validated();
        $this->promoCodesService->create($data);
        return $this->apiResponse();
    }

    public function addCountriesToPromoCode(StorePromoCodeCountriesRequest $request)
    {

        $data = $request->validated();
        $addedCountriesToPromoCode = $this->promoCodesService->addCountriesToPromoCode($data);
        return $this->apiResponse($addedCountriesToPromoCode);
    }

    public function addCompaniesToPromoCode(StorePromoCodeCompaniesRequest $request)
    {

        $data = $request->validated();
        $addedCompaniesToPromoCode = $this->promoCodesService->addCompaniesToPromoCode($data);
        return $this->apiResponse($addedCompaniesToPromoCode);
    }

    public function addProductsToPromoCode(StorePromoCodeProductsRequest $request)
    {

        $data = $request->validated();
        $this->promoCodesService->addProductsToPromoCode($data);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request)
    {

        $promoCode = $request->validated();
        $this->promoCodesService->update($promoCode);
        return $this->apiResponse();
    }

    public function delete($id){

        $this->promoCodesService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }

    public function toggleActivation($id, $activationStatus)
    {

        $this->promoCodesService->toggleActivation($id, $activationStatus);
        return $this->apiResponse();
    }
}
