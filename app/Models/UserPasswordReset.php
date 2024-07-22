<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPasswordReset extends Model
{

    protected $table = "users_password_resets";
    use HasFactory;
    const UPDATED_AT = null;
    public $incrementing = false;
    protected $primaryKey =
        'user_id';

    protected $fillable = [

        'user_id', 'token', 'created_at'
    ];

    public function user()
    {

        return $this->belongsTo(User::class, "user_id", "id");
    }
}
