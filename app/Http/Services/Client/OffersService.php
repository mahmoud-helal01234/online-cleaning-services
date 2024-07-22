<?php

namespace App\Http\Services\Client;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Services\Offers\PromoCodesService;
use App\Http\Services\Offers\PromoCodeOffersService;
use App\Http\Services\PagesContent\SliderOffersService;
use App\Http\Services\PagesContent\HomePageContentService;
use App\Http\Services\PagesContent\NavbarFooterContentService;



class OffersService {

    use ResponsesTrait;
    use FileUploadTrait;
    public $sliderOffersService;
    public $promoCodeService;
    public $navbarFooterContentService;
    public $pageContentService;

    public $promoCodeOffersService;
    public function __construct() {

        $this->promoCodeOffersService = new PromoCodeOffersService();
        $this->promoCodeService = new PromoCodesService();
        $this->navbarFooterContentService = new NavbarFooterContentService();
        $this->pageContentService = new HomePageContentService();
     }
    public function get(){

        $offers['promo_code_offers'] = $this->promoCodeOffersService->get();
       // $offers['promo_codes'] = $this->promoCodeService->get();
        $offers['navbar_footer'] = $this->navbarFooterContentService->get();
        $offers['page_content'] = $this->pageContentService->get();

        return $offers;
    }

}
