<?php

namespace App\Models;

use App\Http\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffersPageContent extends Model
{

    protected $table = "offers_page_content";
    use HasFactory;
    use FileUploadTrait;
    protected $fillable = [

        'title_ar',	'title_en',	'second_title_ar',	'second_title_en',	'logo_path',
        'img_path', 'google_play_link', 'app_store_link', 'content_ar', 'content_en'
    ];

    public $timestamps = false;


    public function setImgPathAttribute($value)
    {

        $this->attributes['img_path'] = $this->uploadFile($value,'images/offers_page', $this->attributes['img_path'] ?? "");
    }
    public function setLogoPathAttribute($value)
    {

        $this->attributes['logo_path'] = $this->uploadFile($value,'images/offers_page', $this->attributes['logo_path'] ?? "");
    }
}
