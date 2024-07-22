<?php

namespace App\Models;

use App\Http\Traits\ImagesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CooperationWithUsReason extends Model
{
    use HasFactory,SoftDeletes;
    use FileUploadTrait;
    use ImagesTrait;


    protected $fillable = [

        'id', 'title_ar', 'title_en','img_path', 'created_at', 'updated_at','active','deleted_at'
    ];
    protected $hidden = ['deleted_at'];

    public function setImgPathAttribute($value)
    {
        $this->attributes['img_path'] = $this->uploadFile($value,'images/coopration_with_us_reasons', $this->attributes['img_path'] ?? "");
    }


}
