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

        'title_ar',	'title_en',	'content_ar', 'content_en', 'button_text_ar', 'button_text_en'
    ];

    public $timestamps = false;


}
