<?php

namespace App\Http\Controllers\PagesContent;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Http\Requests\PaymentMethod\StoreRequest;
use App\Http\Requests\PaymentMethod\UpdateRequest;
use App\Http\Services\PagesContent\PaymentMethodsService;

class PaymentMethodsController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;

    private $paymentMethodsService;
    public function __construct()
    {

        $this->paymentMethodsService = new PaymentMethodsService();
    }

    public function get()
    {

        $paymentMethods = $this->paymentMethodsService->get();
        return $this->apiResponse($paymentMethods);
    }

    public function create(StoreRequest $request)
    {

        $paymentMethod = $request->validated();
        $this->paymentMethodsService->create($paymentMethod);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request)
    {

        $paymentMethod = $request->validated();
        $this->paymentMethodsService->update($paymentMethod);
        return $this->apiResponse();
    }

    public function toggleActivation($id, $activationStatus)
    {

        $this->paymentMethodsService->toggleActivation($id, $activationStatus);
        return $this->apiResponse();
    }

    public function delete($id)
    {

        $this->paymentMethodsService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }

}


