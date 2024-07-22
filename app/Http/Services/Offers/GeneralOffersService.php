<?php

namespace App\Http\Services\Offers;

use App\Http\Traits\ResponsesTrait;
use App\Models\GeneralOffer;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\FileUploadTrait;
use App\Http\Traits\ImagesTrait;
use App\Http\Traits\LoggedInUserTrait;
use Carbon\Carbon;

class GeneralOffersService
{

    use ResponsesTrait;
    use FileUploadTrait;
    use LoggedInUserTrait;
    use ImagesTrait;

    public function get($active = null)
    {

        $user = $this->getLoggedInUser();
        switch ($user->role) {

            case "admin":

                $generalOffers = GeneralOffer::when($active != null, function ($query) use ($active) {

                    $query->where('active', $active);
                })->orderBy('created_at', 'DESC')->get();

                break;

                case "client":  // tested and done

                $generalOffers = GeneralOffer::where('active', 1)->where('from', '<=', Carbon::now())->where('to', '>=', Carbon::now())->orderBy('created_at', 'DESC')->select('id', 'to', 'img_path')->get();
                break;
        }

        return $generalOffers;
    }

    public function getById($id)
    {

        $generalOffer = GeneralOffer::find($id);
        if ($generalOffer == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $generalOffer;
    }

    public function create($generalOffer)
    {

        try {

            $createdGeneralOffer = GeneralOffer::create($generalOffer);
            return $createdGeneralOffer;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function update($newGeneralOffer)
    {

        $generalOffer = $this->getById($newGeneralOffer['id']);
        try {

            $generalOffer->update($newGeneralOffer);
            return $generalOffer;
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

        $generalOffer = $this->getById($id);

        try {

            $imgPath = $generalOffer->img_path;
            $generalOffer->delete();
            $this->deleteFile($imgPath);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }
}
