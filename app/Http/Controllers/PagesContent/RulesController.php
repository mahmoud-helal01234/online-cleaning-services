<?php

namespace App\Http\Controllers\PagesContent;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Http\Requests\Rule\StoreRequest;
use App\Http\Requests\Rule\UpdateRequest;
use App\Http\Services\PagesContent\RulesService;

class RulesController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;

    private $rulesService;
    public function __construct()
    {

        $this->rulesService = new RulesService();

    }

    public function get()
    {

        $rules = $this->rulesService->get();
        return $this->apiResponse($rules);
    }

    public function create(StoreRequest $request)
    {

        $rule = $request->validated();
        $this->rulesService->create($rule);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request)
    {

        $rule = $request->validated();
        $this->rulesService->update($rule);
        return $this->apiResponse();
    }

    public function delete($id)
    {

        $this->rulesService->delete($id);
        return $this->apiResponse(message: __('deleted'));
    }

}


