<?php

namespace App\Http\Services\Client;

use App\Http\Services\PagesContent\HomePageContentService;
use App\Http\Services\PagesContent\HomeSliderImagesService;
use App\Http\Services\PagesContent\NavbarFooterContentService;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;



class HomePageService {

    use ResponsesTrait;
    use FileUploadTrait;
    public $homePageService;
    public $navbarFooterContentService;
    public $homeSliderImagesService;
    public function __construct() {

        $this->homePageService = new HomePageContentService();
        $this->navbarFooterContentService = new NavbarFooterContentService();
        $this->homeSliderImagesService = new HomeSliderImagesService();
     }
    public function get(){

        $home['home_page'] = $this->homePageService->get();
      //  $home['home_slider_img'] = $this->homeSliderImagesService->get();
        $home['navbar_footer'] = $this->navbarFooterContentService->get();

        return $home;
    }

}
