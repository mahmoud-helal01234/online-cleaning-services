<?php
namespace App\Http\Traits;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait ImagesTrait {

    /**
     * @param Request $request
     * @return $this|false|string
     */
    public function upload(FormRequest $request, $fieldname = 'image', $directory = 'images' ) {


    return $request->file($fieldname)->store($directory, 'public');
    }

    public function imageUrl($imagePath){

        return $imagePath != null ? url($imagePath) : $imagePath;
    }

    public function deleteImage($imgPath)
    {

        // if (File::exists("storage/app/public/images/countries/FhmfmuA7An9KBL1koInhRdVw4g0cUsbsssW06XX1.png")) {

        //     ## Delete file
        //     File::delete(public_path($imgPath));
        //     return true;
        // }

        if(Storage::exists("public/".$imgPath)){

            Storage::delete("public/".$imgPath);
            /*
                Delete Multiple files this way
                Storage::delete(['upload/test.png', 'upload/test2.png']);
            */
            return true;
        }else{

            return false;
        }
    }
}



