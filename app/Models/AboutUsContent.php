<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUsContent extends Model
{

    protected $table = "about_us_content";
    use HasFactory;

    protected $fillable = [

        'id', 'title_ar', 'title_en', 'content_ar', 'content_en' ,'long' ,'lat'
    ];
    protected $hidden = ['deleted_at'];
    public $timestamps = false;


}
