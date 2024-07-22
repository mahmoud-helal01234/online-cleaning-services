<?php

namespace App\Http\Services\Offers;

use App\Models\PromoCodeOffer;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class PromoCodeOffersService
{

    use ResponsesTrait;
    use LoggedInUserTrait;

    public function get($promoCodeId = null,$active = null)
    {

        $loggedInUser = $this->getLoggedInUser();
        if($loggedInUser != null){
            if($loggedInUser->role == "admin"){

            }
        }

        $data = PromoCodeOffer::with(['promoCode:id,code,from,to','promoCode.companies.company.user'])

        ->when($promoCodeId != null, function ($query) use ($promoCodeId){
            $query->where('promo_code_id',$promoCodeId);
        })->when($active != null, function ($query) use ($active) {

            $query->where('active', $active)->orderBy('to', 'DESC');
        })->get();



        return $data;
    }


    public function getById($id)
    {

        $promoCodeOffer = PromoCodeOffer::find($id);

        if ($promoCodeOffer == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));

        return $promoCodeOffer;
    }

    public function create($promoCodeOffer)
    {

        try {

            PromoCodeOffer::create($promoCodeOffer);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function update($newPromoCodeOffer)
    {

        $promoCodeOffer = $this->getById($newPromoCodeOffer['id']);
        try {

            $promoCodeOffer->update($newPromoCodeOffer);
            return $promoCodeOffer;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function toggleActivation($id, $activationStatus)
    {

        $promoCodeOffer = $this->getById($id);
        try {

            $promoCodeOffer->update(['active' => $activationStatus]);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id)
    {

        $promoCodeOffer = $this->getById($id);

        try {

            $promoCodeOffer->delete();
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }
}
