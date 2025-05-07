<?php

namespace App\Models;

use App\Http\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class HomePageContent extends Model
{

    protected $table = "home_page_content";
    use HasFactory;
    use FileUploadTrait;
    protected $fillable = [

        "section1_title_en",
        "section1_desc_en",
        "google_play_link",
        "app_store_link",
        "about_title_en",
        "about_description_en",
        "about_image",
        "services_title_en",
        "services_description_en",
        "our_clients_reviews_title_en",
        
        "section1_title_ar",
        "section1_desc_ar",
        "about_title_ar",
        "about_description_ar",
        "services_title_ar",
        "services_description_ar",
        "our_clients_reviews_title_ar"

    ];

    public $timestamps = false;

    public function setAboutImageAttribute($value)
    {

        $this->attributes['about_image'] = $this->uploadFile($value, 'images/aboutImage', $this->attributes['about_image'] ?? "");
    }

}
