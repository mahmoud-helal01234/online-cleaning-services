<?php

namespace App\Http\Services\Client;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Services\Offers\OffersService;
use App\Http\Services\PagesContent\HomePageContentService;



class ClientAppHomeService {

    use ResponsesTrait;
    use FileUploadTrait;
    public $homePageService;
    public $sliderOffersService;
    public $offersService;


    public function __construct() {

        $this->homePageService = new HomePageContentService();
        $this->offersService = new OffersService();

     }
    public function get(){

        $home['home_page'] = $this->homePageService->get();
        $home['offers'] = $this->offersService->get();

        return $home;
    }

}
