<?php

namespace App\Http\Services\Wallets;

use App\Http\Traits\ResponsesTrait;
use App\Models\WalletCreditOffer;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\FileUploadTrait;
use App\Http\Traits\ImagesTrait;
use App\Http\Traits\LoggedInUserTrait;

class WalletCreditOffersService {

    use ResponsesTrait;
    use FileUploadTrait;
    use LoggedInUserTrait;
    use ImagesTrait;


    public function get(){

        $role = $this->getLoggedInUserRole();

        switch($role){

            case "admin":
            case "client":
                $walletCreditOffers = WalletCreditOffer::get();
            break;

        }

        return $walletCreditOffers;
    }

    public function getById($id){

        $walletCreditOffer = WalletCreditOffer::find($id);

        if($walletCreditOffer == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $walletCreditOffer;
    }

    public function create($walletCreditOffer){

        try{

            $createdWalletCreditOffer = WalletCreditOffer::create($walletCreditOffer);
            return $createdWalletCreditOffer;
        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function update($newWalletCreditOffer){

        $walletCreditOffer = $this->getById($newWalletCreditOffer['id']);
        try{

            $walletCreditOffer->update($newWalletCreditOffer);
            return $walletCreditOffer;
        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id){

        $walletCreditOffer = $this->getById($id);

        try{

            $imgPath = $walletCreditOffer->img_path;
            $walletCreditOffer->delete();
            $this->deleteFile($imgPath);

        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }



}
