<?php

namespace App\Http\Controllers\PagesContent;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Http\Requests\CooperationWithUsReason\StoreRequest;
use App\Http\Requests\CooperationWithUsReason\UpdateRequest;
use App\Http\Services\PagesContent\CooperationWithUsReasonsService;

class CooperationWithUsReasonsController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;
    private $cooperationWithUsReasonsService;

    public function __construct()
    {

        $this->cooperationWithUsReasonsService = new CooperationWithUsReasonsService();
    }


    public function get(){


        $cooperationWithUsReasons = $this->cooperationWithUsReasonsService->get();
        return $this->apiResponse($cooperationWithUsReasons );
    }

    public function create(StoreRequest $request)
    {

        $cooperationWithUsReason = $request->validated();

        $this->cooperationWithUsReasonsService->create($cooperationWithUsReason);

        return $this->apiResponse();
    }

    public function toggleActivation($id, $activationStatus)
    {

        $this->cooperationWithUsReasonsService->toggleActivation($id, $activationStatus);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request)
    {

        $cooperationWithUsReason = $request->validated();

        $this->cooperationWithUsReasonsService->update($cooperationWithUsReason);

        return $this->apiResponse();

    }

    public function delete($id)
    {

        $this->cooperationWithUsReasonsService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }



}
