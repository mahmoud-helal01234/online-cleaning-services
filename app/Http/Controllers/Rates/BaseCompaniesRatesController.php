<?php

namespace App\Http\Controllers\Rates;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Services\Rates\BaseCompaniesRatesService;
use App\Http\Requests\BaseCompaniesRate\StoreRequest;
use App\Http\Requests\BaseCompaniesRate\UpdateRequest;
use App\Http\Controllers\Controller;

class BaseCompaniesRatesController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;
    private $baseCompaniesRatesService;

    public function __construct()
    {

        $this->baseCompaniesRatesService = new BaseCompaniesRatesService();
    }

    public function get()
    {

        $baseCompaniesRates = $this->baseCompaniesRatesService->get();
        return $this->apiResponse($baseCompaniesRates);
    }

    public function create(StoreRequest $request)
    {

        $data = $request->validated();
        $this->baseCompaniesRatesService->create($data);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request)
    {

        $baseCompaniesRate = $request->validated();
        $this->baseCompaniesRatesService->update($baseCompaniesRate);
        return $this->apiResponse();
    }

    public function delete($id){

        $this->baseCompaniesRatesService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }
}
