<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\File;

trait FileUploadTrait
{
    protected function uploadFile ($file, $location ,$imagePath = null) {

        if($imagePath)
        {
            $img = public_path($imagePath);
            File::delete($img);
        }

        $file_original_name = $file->getClientOriginalName();
        $file_original_extension = $file->getClientOriginalExtension();
        $file_unique_name = time().rand(100,999) .'.'. $file_original_extension;
        $new_path = $location;
        $folder_path = public_path($new_path);
        $file -> move($folder_path, $file_unique_name);
        return $new_path.'/'.$file_unique_name;
    }

    public function deleteFile($filePath){
        if($filePath)
        {
            $img = public_path($filePath);
            File::delete($img);
        }
    }

}
