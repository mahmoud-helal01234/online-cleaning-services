<?php

namespace App\Models;

use App\Models\Company;
use App\Models\Country;
use App\Http\Traits\FileUploadTrait;
use App\Http\Traits\ImagesTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use FileUploadTrait;
    use ImagesTrait,SoftDeletes;
    protected $fillable = [

        'id',
        'name_ar',
        'name_en',
        'img_path',
        'active',
    ];

    protected $hidden = ['pivot', 'deleted_at'];
    public function setImgPathAttribute($value)
    {
        $this->attributes['img_path'] = $this->uploadFile($value,'images/categories', $this->attributes['img_path'] ?? "");
    }

}
