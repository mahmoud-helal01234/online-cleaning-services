<?php

namespace App\Http\Controllers\PagesContent;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Http\Requests\OrderStep\StoreRequest;
use App\Http\Requests\OrderStep\UpdateRequest;
use App\Http\Services\PagesContent\OrderStepsService;

class OrderStepsController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;
    private $orderStepsService;

    public function __construct()
    {

        $this->orderStepsService = new OrderStepsService();
    }


    public function get(){

        $orderSteps = $this->orderStepsService->get();
        return $this->apiResponse($orderSteps );
    }

    public function create(StoreRequest $request)
    {

        $orderStep = $request->validated();
        $this->orderStepsService->create($orderStep);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request)
    {

        $orderStep = $request->validated();

        $this->orderStepsService->update($orderStep);

        return $this->apiResponse();

    }

    public function toggleActivation($id, $activationStatus)
    {

        $this->orderStepsService->toggleActivation($id, $activationStatus);
        return $this->apiResponse();
    }

    public function delete($id)
    {

        $this->orderStepsService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }

}
