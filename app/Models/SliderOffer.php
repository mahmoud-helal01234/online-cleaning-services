<?php

namespace App\Models;


use App\Http\Traits\ImagesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SliderOffer extends Model
{
    use HasFactory,SoftDeletes;
    use FileUploadTrait;
    use ImagesTrait;

    protected $fillable = [

        'id',
        'img_path',
        'link',
        'from',
        'to',
        'active',

    ];
    protected $hidden = ['deleted_at'];


    public function setImgPathAttribute($value)
    {
        $this->attributes['img_path'] = $this->uploadFile($value,'images/link_offers', $this->attributes['img_path'] ?? "");
    }

}
