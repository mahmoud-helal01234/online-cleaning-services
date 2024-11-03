<?php

namespace App\Models\DriversApp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDeviceToken extends Model
{
    use HasFactory;
    protected $table = 'user_device_tokens';
    protected $fillable = [
        'user_id' , 'device_token', 'created_at'
    ];


}
