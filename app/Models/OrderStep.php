<?php

namespace App\Models;

use App\Http\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderStep extends Model
{

    use HasFactory, FileUploadTrait, SoftDeletes;

    protected $fillable = [

        'id', 'title_ar', 'title_en', 'description_ar', 'description_en',
        'img_path', 'created_at', 'updated_at', 'active'
    ];
    protected $hidden = ['deleted_at'];

    public function setImgPathAttribute($value)
    {
        $this->attributes['img_path'] = $this->uploadFile($value, 'images/order_steps', $this->attributes['img_path'] ?? "");
    }
}
