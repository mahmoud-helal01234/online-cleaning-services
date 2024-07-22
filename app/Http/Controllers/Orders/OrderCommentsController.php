<?php

namespace App\Http\Controllers\Orders;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Services\Orders\OrderCommentsService;
use App\Http\Requests\OrderComment\StoreRequest;
use App\Http\Requests\OrderComment\UpdateRequest;
use App\Http\Controllers\Controller;

class OrderCommentsController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;
    private $orderCommentsService;

    public function __construct()
    {

        $this->orderCommentsService = new OrderCommentsService();
    }


    public function get($orderId){

        $orderComments = $this->orderCommentsService->get($orderId);
        return $this->apiResponse($orderComments);
    }

    public function create(StoreRequest $request)
    {

        $orderComment = $request->validated();
        $this->orderCommentsService->create($orderComment);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request)
    {

        $orderComment = $request->validated();
        $this->orderCommentsService->update($orderComment);
        return $this->apiResponse();
    }

    public function toggleShowForClient($id, $showForClient)
    {

        $this->orderCommentsService->toggleShowForClient($id, $showForClient);
        return $this->apiResponse();
    }

    public function delete($id)
    {

        $this->orderCommentsService->delete($id);
        return $this->apiResponse(message: __('deleted'));
    }

}
