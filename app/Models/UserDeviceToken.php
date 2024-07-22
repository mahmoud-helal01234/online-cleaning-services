<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDeviceToken extends Model
{

    use HasFactory;
    protected $table = "user_device_tokens";
    const UPDATED_AT = null;

    protected $fillable = [

        'user_id', 'device_token', 'created_at'
    ];

    public function user()
    {

        return $this->belongsTo(User::class, "user_id", "id");
    }
}
