<?php

namespace App\Http\Services\PagesContent;

use App\Models\Review;
use App\Models\SocialLink;
use App\Models\HomePageContent;
use App\Models\HomeSliderImage;
use App\Models\FloatingSocialLink;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class HomePageContentService
{

    use ResponsesTrait;
    use FileUploadTrait;
    use LoggedInUserTrait;

    public function get()
    {

        $loggedInUser = $this->getLoggedInUser();

        if ($loggedInUser != null){
            if($loggedInUser->role == "admin"){

                $data = HomePageContent::first();
                return $data;
            }
        }
        $data = HomePageContent::first();
        $data['floating_social_link'] = FloatingSocialLink::where('active', 1)->orderBy('created_at', 'DESC')->select('img_path')->get();
        $data['social_links'] = SocialLink::where('active', 1)->orderBy('created_at', 'DESC')->select('img_path')->get();
        $data['reviews'] = Review::where('active', 1)->orderBy('created_at', 'DESC')->select('img_path')->get();

        return $data;
    }

    public function update($newHomePageContent)
    {

        try {

            $homePageContent = HomePageContent::updateOrCreate(['id' => 1], $newHomePageContent);
            return $homePageContent;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }
}
