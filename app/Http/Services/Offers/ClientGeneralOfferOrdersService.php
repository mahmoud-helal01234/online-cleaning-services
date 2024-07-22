<?php

namespace App\Http\Services\Offers;

use App\Http\Traits\ResponsesTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\LoggedInUserTrait;
use App\Models\ClientGeneralOfferOrder;

class ClientGeneralOfferOrdersService
{

    use ResponsesTrait;
    use LoggedInUserTrait;

    public function get()
    {

        $user = $this->getLoggedInUser();
        $clientGeneralOfferOrders = ClientGeneralOfferOrder::with(['generalOffer' => function ($query){

            $query->select('id','img_path');
        },'invoice']);
        switch ($user->role) {


            case "client":  // tested and done
                $clientGeneralOfferOrders = $clientGeneralOfferOrders->where('client_id', $user->id);
                break;
        }
        $clientGeneralOfferOrders = $clientGeneralOfferOrders->select('id', 'content', 'status', 'invoice_id', 'general_offer_id')
        ->orderBy('created_at', 'DESC')->get();
        return $clientGeneralOfferOrders;
    }

    public function getById($id)
    {

        $clientGeneralOfferOrder = ClientGeneralOfferOrder::find($id);
        if ($clientGeneralOfferOrder == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $clientGeneralOfferOrder;
    }

    public function create($clientGeneralOfferOrder)
    {

        try {

            ClientGeneralOfferOrder::create($clientGeneralOfferOrder);

        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function update($newClientGeneralOfferOrder)
    {

        $clientGeneralOfferOrder = $this->getById($newClientGeneralOfferOrder['id']);
        try {

            $clientGeneralOfferOrder->update($newClientGeneralOfferOrder);
            return $clientGeneralOfferOrder;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id)
    {

        $clientGeneralOfferOrder = $this->getById($id);
        try {

            $clientGeneralOfferOrder->delete();
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }
}
