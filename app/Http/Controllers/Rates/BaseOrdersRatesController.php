<?php

namespace App\Http\Controllers\Rates;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Services\Rates\BaseOrdersRatesService;
use App\Http\Requests\BaseOrdersRate\StoreRequest;
use App\Http\Requests\BaseOrdersRate\UpdateRequest;
use App\Http\Controllers\Controller;

class BaseOrdersRatesController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;
    private $baseOrdersRatesService;

    public function __construct()
    {

        $this->baseOrdersRatesService = new BaseOrdersRatesService();
    }

    public function get()
    {

        $baseOrdersRates = $this->baseOrdersRatesService->get();
        return $this->apiResponse($baseOrdersRates);
    }

    public function create(StoreRequest $request)
    {

        $data = $request->validated();
        $this->baseOrdersRatesService->create($data);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request)
    {

        $baseOrdersRate = $request->validated();
        $this->baseOrdersRatesService->update($baseOrdersRate);
        return $this->apiResponse();
    }

    public function delete($id){

        $this->baseOrdersRatesService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }
}
