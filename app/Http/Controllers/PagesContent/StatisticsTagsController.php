<?php

namespace App\Http\Controllers\PagesContent;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Http\Requests\StatisticsTag\StoreRequest;
use App\Http\Requests\StatisticsTag\UpdateRequest;
use App\Http\Services\PagesContent\StatisticsTagsService;

class StatisticsTagsController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;
    private $statisticsTagsService;

    public function __construct()
    {

        $this->statisticsTagsService = new StatisticsTagsService();
    }


    public function get(){

        $statisticsTags = $this->statisticsTagsService->get();
        return $this->apiResponse($statisticsTags );
    }

    public function create(StoreRequest $request)
    {

        $statisticsTag = $request->validated();
        $this->statisticsTagsService->create($statisticsTag);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request)
    {

        $statisticsTag = $request->validated();

        $this->statisticsTagsService->update($statisticsTag);

        return $this->apiResponse();

    }

    public function delete($id)
    {

        $this->statisticsTagsService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }

}
