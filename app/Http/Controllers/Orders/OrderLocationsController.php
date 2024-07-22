<?php

namespace App\Http\Controllers\Orders;

use Illuminate\Http\Request;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Requests\OrderLocation\StoreRequest;
use App\Http\Services\Orders\OrderLocationsService;
use App\Http\Controllers\Controller;


class OrderLocationsController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;

    private $orderLocationsService;

    public function __construct()
    {

        $this->orderLocationsService = new OrderLocationsService();
    }

    public function get(Request $request)
    {

        $orderLocations = $this->orderLocationsService->get(request('order_id'));
        return $this->apiResponse($orderLocations);
    }

    public function create(StoreRequest $request)
    {

        $orderLocation = $request->validated();

         $this->orderLocationsService->create($orderLocation);

        return $this->apiResponse();
    }

    // public function update(UpdateRequest $request)
    // {

    //     $orderLocation = $request->validated();

    //     $this->orderLocationsService->update($orderLocation);

    //     return $this->apiResponse();
    // }

    public function delete($id)
    {

        $this->orderLocationsService->delete($id);

        return $this->apiResponse(null, true, __('deleted'));
    }

}

