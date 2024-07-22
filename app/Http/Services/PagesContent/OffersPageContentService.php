<?php

namespace App\Http\Services\PagesContent;

use App\Models\OffersPageContent;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class OffersPageContentService
{

    use ResponsesTrait;
    use FileUploadTrait;

    public function get()
    {

        $offersPageContent = OffersPageContent::select('title_ar', 'title_en', 'second_title_ar', 'second_title_en', 'logo_path', 'img_path', 'google_play_link', 'app_store_link', 'content_ar', 'content_en')->first();
        return $offersPageContent;
    }

    public function update($newOffersPageContent)
    {


        try {

            $offersPageContent = OffersPageContent::updateOrCreate(['id' => 1], $newOffersPageContent);
            return $offersPageContent;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }
}
