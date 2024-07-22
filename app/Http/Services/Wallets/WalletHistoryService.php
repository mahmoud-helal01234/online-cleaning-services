<?php

namespace App\Http\Services\Wallets;

use App\Models\WalletHistory;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class WalletHistoryService {

    use ResponsesTrait;
    use FileUploadTrait;
    use LoggedInUserTrait;

    public function get($clientId = null){

        $user = $this->getLoggedInUser();

        switch ($user->role) {
            case "admin":

                $data = WalletHistory::where('client_id',$clientId)->orderBy('created_at','DESC')->get();
                break;
            case "client": // tested and done

                $clientId = $user->id;
                $data = WalletHistory::where('client_id',$clientId)->orderBy('created_at','DESC')->get();
                break;
        }


        return $data;
    }

    public function getById($id){

        $walletHistory = WalletHistory::find($id);

        if($walletHistory == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));

        return $walletHistory;
    }

    public function create($walletHistory){

        try{

            $createdWalletHistory = WalletHistory::create($walletHistory);
            return $createdWalletHistory;

        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function update($newWalletHistory){

        $walletHistory = $this->getById($newWalletHistory['id']);
        try{

            $walletHistory->update($newWalletHistory);
            return $walletHistory;
        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id){

        $walletHistory = $this->getById($id);

        try{

            $walletHistory->delete();
        } catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }

}
