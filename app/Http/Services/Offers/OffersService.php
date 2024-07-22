<?php

namespace App\Http\Services\Offers;

use App\Models\Offer;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class OffersService
{

    use ResponsesTrait;
    use LoggedInUserTrait;

    public function get()
    {

        $data = Offer::with('companies')->get();
        return $data;
    }


    public function getById($id)
    {

        $offer = Offer::find($id);

        if ($offer == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));

        return $offer;
    }

    public function create($offerData)
    {


            $offer = Offer::create($offerData);
            if (isset($offerData['companies']) && is_array($offerData['companies'])) {

                // Attach companies to the offer
                $offer->companies()->attach($offerData['companies']);
            }try {
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));
        }
    }

    public function update($newOffer)
    {

        $offer = $this->getById($newOffer['id']);

        try {

            $offer->update($newOffer);

            if (isset($newOffer['companies']) && is_array($newOffer['companies'])) {
                // Sync (detach and attach) the new companies
                $offer->companies()->sync($newOffer['companies']);
            }
            return $offer;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function toggleActivation($id, $activationStatus)
    {

        $offer = $this->getById($id);
        try {

            $offer->update(['active' => $activationStatus]);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id)
    {

        $offer = $this->getById($id);

        try {
            $offer->companies()->detach($offer->company_id);
            $offer->delete();
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }
}
