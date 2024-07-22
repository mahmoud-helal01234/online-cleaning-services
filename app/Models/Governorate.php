<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Governorate extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [

        'name_ar', 'name_en', 'country_id','active', 'created_at', 'updated_at','active'
    ];
    protected $hidden = [
        'deleted_at'
    ];
    // protected static function booted()
    // {

    //     static::deleting(function ($governorate) {


    //             $governorate->cities()->delete();
    //     });
    // }
    public function country(){

        return $this->belongsTo(Country::class,'country_id','id');
    }
    public function cities(){

        return $this->hasMany(City::class,'governorate_id','id');
    }
}
