<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Services\SettingsService;
use App\Http\Requests\Setting\UpdateRequest;

class SettingsController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;
    private $settingsService;

    public function __construct()
    {

        $this->settingsService = new SettingsService();
    }

    public function get()
    {

        $settings = $this->settingsService->get();
        return $this->apiResponse($settings);
    }

    public function update(UpdateRequest $request)
    {

        $settings = $request->validated();
        $this->settingsService->update($settings);
        return $this->apiResponse();
    }

}
