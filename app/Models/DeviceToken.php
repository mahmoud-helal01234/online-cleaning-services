<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{

    use HasFactory;

    protected $table = 'user_device_tokens';
    protected $fillable = [

        'id',
        'user_id',
        'device_token',
        'created_at',
    ];

}

