<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    protected $table = "notifications";
    use HasFactory;

    protected $fillable = [


        'user_id', 'title_ar', 'title_en', 'order_id', 'body_ar', 'body_en', 'action', 'action_data',
    ];
    public $timestamps = false;
}
