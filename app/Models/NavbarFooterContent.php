<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavbarFooterContent extends Model
{

    protected $table = "nav_bar_footer_content";
    use HasFactory;

    protected $fillable = [

        'whatsapp_number',
        'phone_number', 'facebook_link', 'instagram_link', 'twitter_link', 'footer_title_ar', 'footer_title_en', 'footer_content_ar', 'footer_content_en'
    ];
    public $timestamps = false;
}
