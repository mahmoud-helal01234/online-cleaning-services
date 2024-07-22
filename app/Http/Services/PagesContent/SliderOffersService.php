<?php

namespace App\Http\Services\PagesContent;

use App\Http\Traits\ResponsesTrait;
use App\Models\SliderOffer;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\FileUploadTrait;
use App\Http\Traits\LoggedInUserTrait;

class SliderOffersService
{

    use ResponsesTrait;
    use FileUploadTrait;
    use LoggedInUserTrait;


    public function get($active = null)
    {

        $user = $this->getLoggedInUser();
        if (!$user) {
            $linkOffers = SliderOffer::where('active', 1)->orderBy('created_at', 'DESC')->get();
        }
        else {
            switch ($user->role) {

                case "admin":
                    $linkOffers = SliderOffer::when($active != null, function ($query) use ($active) {

                        $query->where('active', $active);
                    })->orderBy('created_at', 'DESC')->get();

                    break;

                case "client":
                    $linkOffers = SliderOffer::where('active', 1)->orderBy('created_at', 'DESC')->get();
                    break;
            }
        }
        return $linkOffers;
    }

    public function getById($id)
    {

        $linkOffer = SliderOffer::find($id);
        if ($linkOffer == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $linkOffer;
    }

    public function create($linkOffer)
    {

        try {
            $createdSliderOffer = SliderOffer::create($linkOffer);
            return $createdSliderOffer;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function update($newSliderOffer)
    {

        $linkOffer = $this->getById($newSliderOffer['id']);
        try {

            $linkOffer->update($newSliderOffer);
            return $linkOffer;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }
    public function toggleActivation($id, $activationStatus)
    {

        $generalOffer = $this->getById($id);
        try {

            $generalOffer->update(['active' => $activationStatus]);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id)
    {

        $linkOffer = $this->getById($id);
        try {

            $imgPath = $linkOffer->img_path;
            $linkOffer->delete();
            $this->deleteFile($imgPath);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }
}
