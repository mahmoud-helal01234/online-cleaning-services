<?php

namespace App\Models;

use App\Http\Traits\ImagesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomeSliderImage extends Model
{
    
    use HasFactory;
    use FileUploadTrait;
    use ImagesTrait;

    protected $fillable = [
        'id',
        'img_path',
        'active'
    ];

    public function setImgPathAttribute($value)
    {
        $this->attributes['img_path'] = $this->uploadFile($value,'images/home_slider', $this->attributes['img_path'] ?? "");
    }

}
