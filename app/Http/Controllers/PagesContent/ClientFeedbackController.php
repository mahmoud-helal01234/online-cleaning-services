<?php

namespace App\Http\Controllers\PagesContent;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Http\Requests\ClientFeedback\StoreRequest;
use App\Http\Requests\ClientFeedback\UpdateRequest;
use App\Http\Services\PagesContent\ClientFeedbackService;

class ClientFeedbackController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;
    private $clientFeedbackService;

    public function __construct()
    {

        $this->clientFeedbackService = new ClientFeedbackService();
    }

    public function get()
    {

        $clientFeedback = $this->clientFeedbackService->get();
        return $this->apiResponse($clientFeedback);
    }

    public function create(StoreRequest $request)
    {

        $data = $request->validated();
        $this->clientFeedbackService->create($data);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request)
    {
        
        $clientFeedback = $request->validated();
        $this->clientFeedbackService->update($clientFeedback);
        return $this->apiResponse();
    }

    public function delete($id){

        $this->clientFeedbackService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }
}
