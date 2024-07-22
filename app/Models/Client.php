<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Country;
use App\Http\Traits\ImagesTrait;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;
    use ResponsesTrait;
    use FileUploadTrait;
    use ImagesTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [

        'id',
        'name',
        'email',
        'phone',
        'password',
        'active',
        'avatar',
        'provider_id',
        'provider_name',
        'access_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'provider_id',
        'provider',
        'provider_name',
        'access_token',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function setPasswordAttribute($value)
    {
        if(!is_null($value))
            $this->attributes['password'] = Hash::make($value);
    }
    public function setAvatarAttribute($value)
    {
        $this->attributes['avatar'] = $this->uploadFile($value, 'images/clients', $this->attributes['avatar'] ?? "");
    }
    
    public function clientLocation(){

        return $this->hasMany(ClientLocation::class,"client_id","id");
    }

    public static function boot()
  {
    parent::boot();

    static::deleting(function ($data)
    {

        $data->id;
        // invalidate tokens for user id
    });

  }


}
