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

/* 

section1_title, section1_desc, google play link, app store link, 
    about_title, about_description, about_image
    services_title, services_description
    our_clients_reviews_title
    list of reviews
    (client name, image, title, description)
    floating social links list of (image, link)
    navbar_social_links list of (image, link)

*/