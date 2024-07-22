<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponsesTrait;
use App\Http\Services\CitiesService;
use App\Http\Traits\FileUploadTrait;
use App\Http\Requests\City\StoreRequest;
use App\Http\Services\StatisticsService;
use App\Http\Requests\City\UpdateRequest;


class StatisticsController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;

    private $statisticsService;

    public function __construct()
    {

        $this->statisticsService = new StatisticsService();
    }

    public function getYearlyStatistics($year)
    {

        $data = $this->statisticsService->getYearlyStatistics($year);
        return $this->apiResponse($data);
    }



}

