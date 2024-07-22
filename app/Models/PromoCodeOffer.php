<?php

namespace App\Models;

use App\Http\Traits\FileUploadTrait;
use App\Models\PromoCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromoCodeOffer extends Model
{

    use HasFactory, FileUploadTrait, SoftDeletes;

    protected $fillable = [

        'promo_code_id', 'img_path', 'active'
    ];
    protected $hidden = [
        'deleted_at',
    ];

    public function setImgPathAttribute($value)
    {

        $this->attributes['img_path'] = $this->uploadFile($value, 'images/products', $this->attributes['img_path'] ?? "");
    }

    public function promoCode()
    {

        return $this->belongsTo(PromoCode::class, 'promo_code_id', 'id');
    }
}
