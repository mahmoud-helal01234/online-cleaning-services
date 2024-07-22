<?php

namespace App\Models;

use App\Http\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GeneralOffer extends Model
{
    use HasFactory,SoftDeletes,FileUploadTrait;

    protected $fillable = [

        'id',
        'img_path',
        'from',
        'to',
        'active',

    ];
    protected $hidden = ['deleted_at'];

    public function setImgPathAttribute($value)
    {
        $this->attributes['img_path'] = $this->uploadFile($value,'images/general_offers', $this->attributes['img_path'] ?? "");
    }

}
