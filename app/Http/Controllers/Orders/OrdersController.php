<?php

namespace App\Http\Controllers\Orders;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Http\Requests\Order\StoreRequest;
use App\Http\Requests\Order\UpdateRequest;

use App\Http\Services\Orders\OrdersService;

use App\Http\Requests\Order\RateOrderRequest;
use App\Http\Requests\Order\StoreItemRequest;
use App\Http\Requests\Order\ChangeCompanyRequest;
use App\Http\Requests\Order\UpdateOrderItemRequest;
use App\Http\Requests\Order\ClientStoreOrderRequest;
use App\Http\Requests\Order\AddProductsToCartRequest;

class OrdersController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;
    private $ordersService;

    public function __construct()
    {

        $this->ordersService = new OrdersService();
    }

    public function get()
    {

        $orders = $this->ordersService->get(statuses : request('statuses') , clientId:request('client_id'), 
        pickupDriverId:request('pickup_driver_id'),deliveryDriverId:request('delivery_driver_id'), from :request('from') , to : request('to'));
        return $this->apiResponse($orders);
    }

    public function getStatuses()
    {

        $orderStatuses = $this->ordersService->getStatuses();
        return $this->apiResponse($orderStatuses);
    }

    public function getForClient()
    {

        $orders = $this->ordersService->getForClient();
        return $this->apiResponse($orders);
    }

     public function createForClient(ClientStoreOrderRequest $request)
    {

        $data = $request->validated();
        
        $createdOrder = $this->ordersService->createForClient($data);
        return $this->apiResponse($createdOrder);
    }

    public function changeOrderStatus($id,$status)
    {

        $this->ordersService->changeOrderStatus($id,$status);
        return $this->apiResponse();
    }

    public function getCartOrderDetails()
    {

        $orders = $this->ordersService->getCartOrderDetails(request('order_id'));
        return $this->apiResponse($orders);
    }

    public function getOrderDetails($id)
    {

        $orders = $this->ordersService->getOrderDetails($id);
        return $this->apiResponse($orders);
    }



    public function rate(RateOrderRequest $request)
    {

        $data = $request->validated();
        $this->ordersService->rate($data);
        return $this->apiResponse();
    }

    public function addItemsToCart(AddProductsToCartRequest $request)
    {

        $data = $request->validated();
        $this->ordersService->addItemsToCart($data);
        return $this->apiResponse();
    }

    public function changeCompany(ChangeCompanyRequest $request)
    {

        $data = $request->validated();
        $this->ordersService->changeCompany($data);
        return $this->apiResponse();
    }

    public function addItem(StoreItemRequest $request)
    {

        $data = $request->validated();
        $this->ordersService->addItem($data);
        return $this->apiResponse(null,true,__('success.added'));
    }

    public function update(UpdateRequest $request)
    {

        $order = $request->validated();
        $this->ordersService->update($order);
        return $this->apiResponse();
    }

    public function updateOrderItem(UpdateOrderItemRequest $request)
    {

        $orderItem = $request->validated();
        $this->ordersService->updateOrderItemQuantity($orderItem);
        return $this->apiResponse();
    }

    public function deleteOrderItem($id){

        $this->ordersService->deleteOrderItem($id);
        return $this->apiResponse(null, true, __('deleted'));
    }

    public function delete($id){

        $this->ordersService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }
}
