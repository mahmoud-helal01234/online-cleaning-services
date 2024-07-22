<?php

namespace App\Models;

use App\Http\Traits\ImagesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class WalletCreditOffer extends Model
{
    use HasFactory, SoftDeletes;
    use FileUploadTrait;
    use ImagesTrait;

    protected $fillable = [

        'id', 'name_ar', 'name_en', 'description_ar', 'description_en',    'img_path',    'value', 'value_type', 'min_amount', 'max_amount', 'active'
    ];
    protected $hidden = ['deleted_at'];


    public function setImgPathAttribute($value)
    {

        $this->attributes['img_path'] = $this->uploadFile($value, 'images/wallet_credit_offers', $this->attributes['img_path'] ?? "");
    }
}
