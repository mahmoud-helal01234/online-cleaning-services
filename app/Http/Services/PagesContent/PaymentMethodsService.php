<?php

namespace App\Http\Services\PagesContent;

use App\Http\Traits\ResponsesTrait;
use App\Models\PaymentMethod;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\FileUploadTrait;
use App\Http\Traits\ImagesTrait;
use App\Http\Traits\LoggedInUserTrait;

class PaymentMethodsService
{

    use ResponsesTrait;
    use FileUploadTrait;
    use LoggedInUserTrait;
    use ImagesTrait;


    public function get()
    {

        $user = $this->getLoggedInUser();

        switch ($user->role) {

            case "admin":
            case "client":
                $paymentMethods = PaymentMethod::get();
                break;
        }

        return $paymentMethods;
    }

    public function getById($id)
    {

        $paymentMethod = PaymentMethod::find($id);

        if ($paymentMethod == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $paymentMethod;
    }

    public function create($paymentMethod)
    {

        try {

            $createdPaymentMethod = PaymentMethod::create($paymentMethod);
            return $createdPaymentMethod;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function update($newPaymentMethod)
    {

        $paymentMethod = $this->getById($newPaymentMethod['id']);
        try {

            $paymentMethod->update($newPaymentMethod);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function toggleActivation($id, $activationStatus)
    {

        $paymentMethod = $this->getById($id);
        try {

            $paymentMethod->update(['active' => $activationStatus]);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));
        }
    }

    public function delete($id)
    {

        $paymentMethod = $this->getById($id);

        try {

            $imgPath = $paymentMethod->img_path;
            $paymentMethod->delete();
            $this->deleteFile($imgPath);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }
}
