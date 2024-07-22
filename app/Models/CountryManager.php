<?php

namespace App\Models;

use App\Models\User;
use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CountryManager extends Model
{
    use HasFactory, SoftDeletes;
    public $timestamps = false;
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $fillable = ['user_id','country_id'];
    protected $hidden = ['deleted_at'];

    public function country(){

        return $this->belongsTo(Country::class,'country_id','id');
    }

    public function user(){

        return $this->belongsTo(User::class,'user_id','id');
    }

}
