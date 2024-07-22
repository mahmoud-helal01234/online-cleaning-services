<?php

namespace App\Models;

use App\Http\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{

    use HasFactory, FileUploadTrait, SoftDeletes;

    protected $fillable = [

        'img_path', 'value', 'value_type', 'type', 'start', 'end', 'active', 'deleted_at'
    ];
    protected $hidden = [
        'deleted_at'
    ];

    public function setImgPathAttribute($value)
    {

        $this->attributes['img_path'] = $this->uploadFile($value, 'images/Offers', $this->attributes['img_path'] ?? "");
    }
    public function companies(){

        return $this->belongsToMany(Company::class,'offers_companies','offer_id','company_id');
    }


}
