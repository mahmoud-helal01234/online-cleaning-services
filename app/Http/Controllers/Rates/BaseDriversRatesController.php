<?php

namespace App\Http\Controllers\Rates;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Services\Rates\BaseDriversRatesService;
use App\Http\Requests\BaseDriversRate\StoreDriversRateRequest;
use App\Http\Requests\BaseDriversRate\UpdateDriversRateRequest;
use App\Http\Controllers\Controller;

class BaseDriversRatesController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;
    private $baseDriversRatesService;

    public function __construct()
    {

        $this->baseDriversRatesService = new BaseDriversRatesService();
    }

    public function get()
    {

        $baseDriversRates = $this->baseDriversRatesService->get();
        return $this->apiResponse($baseDriversRates);
    }

    public function create(StoreDriversRateRequest $request)
    {

        $data = $request->validated();
        $this->baseDriversRatesService->create($data);
        return $this->apiResponse();
    }

    public function update(UpdateDriversRateRequest $request)
    {

        $baseDriversRates = $request->validated();
        $this->baseDriversRatesService->update($baseDriversRates);
        return $this->apiResponse();
    }

    public function delete($id){

        $this->baseDriversRatesService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }
}
