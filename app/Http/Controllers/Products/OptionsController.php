<?php

namespace App\Http\Controllers\Products;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Services\Products\OptionsService;
use App\Http\Requests\Option\StoreRequest;
use App\Http\Requests\Option\UpdateRequest;
use App\Http\Controllers\Controller;

class OptionsController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;

    private $optionsService;
    public function __construct()
    {

        $this->optionsService = new OptionsService();

    }

    public function get()
    {

        $options = $this->optionsService->get();
        return $this->apiResponse($options);
    }

    public function create(StoreRequest $request)
    {

        $option = $request->validated();
        $createdOption = $this->optionsService->create($option);
        return $this->apiResponse($createdOption);
    }

    public function update(UpdateRequest $request)
    {

        $option = $request->validated();
        $updatedOption = $this->optionsService->update($option);
        return $this->apiResponse($updatedOption);
    }

    public function delete($id)
    {

        $this->optionsService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }

    public function toggleActivation($id, $activationStatus)
    {

        $this->optionsService->toggleActivation($id, $activationStatus);
        return $this->apiResponse();
    }

}


