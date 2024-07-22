<?php

namespace App\Http\Services\PagesContent;

use App\Http\Traits\ResponsesTrait;
use App\Models\HomeSliderImage;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\FileUploadTrait;
use App\Http\Traits\LoggedInUserTrait;

class HomeSliderImagesService
{

    use ResponsesTrait;
    use FileUploadTrait;
    use LoggedInUserTrait;

    public function get()
    {

        $user = $this->getLoggedInUser();
        switch ($user->role) {

            case "admin":
                $homeSliderImages = HomeSliderImage::orderBy('created_at', 'DESC')->get();
                break;

            case "client":
                $homeSliderImages = HomeSliderImage::where('active', 1)->orderBy('created_at', 'DESC')->select('img_path')->get();
                break;
        }

        return $homeSliderImages;
    }

    public function getById($id)
    {

        $homeSliderImage = HomeSliderImage::find($id);
        if ($homeSliderImage == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $homeSliderImage;
    }

    public function create($homeSliderImage)
    {

        try {
            $createdHomeSliderImage = HomeSliderImage::create($homeSliderImage);
            return $createdHomeSliderImage;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function update($newHomeSliderImage)
    {

        $homeSliderImage = $this->getById($newHomeSliderImage['id']);
        try {

            $homeSliderImage->update($newHomeSliderImage);
            return $homeSliderImage;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id)
    {

        $homeSliderImage = $this->getById($id);
        try {

            $imgPath = $homeSliderImage->img_path;
            $homeSliderImage->delete();
            $this->deleteFile($imgPath);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }
}
