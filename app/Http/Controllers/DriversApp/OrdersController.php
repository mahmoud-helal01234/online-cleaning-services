<?php

namespace App\Http\Controllers\DriversApp;

use App\Http\Controllers\Controller;

use App\Http\Services\DriversApp\DriversAppOrdersService;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;

use App\Http\Requests\DriversApp\Order\StoreRequest;
use App\Http\Requests\DriversApp\Order\UpdateRequest;


class OrdersController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;
    private $driverAppOrdersService;

    public function __construct()
    {

        $this->driverAppOrdersService = new DriversAppOrdersService();
    }

    public function get()
    {

        $orders = $this->driverAppOrdersService->get(statuses: request('statuses'));
        return $this->apiResponse($orders);
    }

    public function changeOrderStatus($id,$status)
    {

        $this->driverAppOrdersService->changeOrderStatus($id,$status);
        return $this->apiResponse(status:true);
    }


    public function create(StoreRequest $request)
    {
        $data = $request->validated();
        $this->driverAppOrdersService->create($data);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request)
    {

        $order = $request->validated();
        $updatedOrder = $this->driverAppOrdersService->update($order);
        return $this->apiResponse($updatedOrder);
    }


    public function delete($id){

        $this->driverAppOrdersService->delete($id);
        return $this->apiResponse();
    }
}
