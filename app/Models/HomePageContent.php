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

        "section1_title",
        "section1_desc",
        "google_play_link",
        "app_store_link",
        "about_title",
        "about_description",
        "about_image",
        "services_title",
        "services_description",
        "our_clients_reviews_title"
    ];

    public $timestamps = false;
}
