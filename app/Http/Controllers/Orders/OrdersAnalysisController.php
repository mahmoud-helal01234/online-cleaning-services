<?php

namespace App\Http\Controllers\Orders;

use App\Http\Traits\ResponsesTrait;
use App\Http\Services\Orders\OrdersAnalysisService;
use App\Http\Controllers\Controller;

class OrdersAnalysisController extends Controller
{

    use ResponsesTrait;
    private $ordersAnalysisService;

    public function __construct(){

        $this->ordersAnalysisService = new OrdersAnalysisService();
    }
    //
    public function get(){

        return $this->apiResponse($this->ordersAnalysisService->get());
    }

    public function getOrdersAnalysisPerCompany(){

        return $this->apiResponse($this->ordersAnalysisService->getOrdersAnalysisPerCompany(request('company_id'),request('from'),request('to')));
    }

    public function getOrdersCountForWeek($startingDate){

        return $this->apiResponse($this->ordersAnalysisService->getOrdersCountForWeek($startingDate));
    }

}
