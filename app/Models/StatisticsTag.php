<?php

namespace App\Models;

use App\Http\Traits\ImagesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatisticsTag extends Model
{
    use HasFactory,SoftDeletes;
    use FileUploadTrait;
    use ImagesTrait;

    protected $fillable = [

        'id', 'title_ar', 'title_en', 'percentage', 'img_path', 'created_at', 'updated_at','active'
    ];
    protected $hidden = ['deleted_at'];

    public function setImgPathAttribute($value)
    {
        $this->attributes['img_path'] = $this->uploadFile($value,'images/statistics_tags', $this->attributes['img_path'] ?? "");
    }

}
