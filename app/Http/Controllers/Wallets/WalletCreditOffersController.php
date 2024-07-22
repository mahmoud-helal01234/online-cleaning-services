<?php

namespace App\Http\Controllers\Wallets;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Services\Wallets\WalletCreditOffersService;
use App\Http\Requests\WalletCreditOffer\StoreRequest;
use App\Http\Requests\WalletCreditOffer\UpdateRequest;
use App\Http\Controllers\Controller;

class WalletCreditOffersController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;

    private $walletCreditOffersService;
    public function __construct()
    {

        $this->walletCreditOffersService = new WalletCreditOffersService();
    }

    public function get()
    {

        $walletCreditOffers = $this->walletCreditOffersService->get();
        return $this->apiResponse($walletCreditOffers);
    }

    public function create(StoreRequest $request)
    {

        $walletCreditOffer = $request->validated();
        $this->walletCreditOffersService->create($walletCreditOffer);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request)
    {

        $walletCreditOffer = $request->validated();
        $this->walletCreditOffersService->update($walletCreditOffer);
        return $this->apiResponse();
    }

    public function delete($id)
    {

        $this->walletCreditOffersService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }

}


