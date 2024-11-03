<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

// class PromoCodeOld extends Model
// {

//     use HasFactory, SoftDeletes;

//     protected $fillable = [

//         'code', 'value', 'value_type', 'type', 'from', 'to', 'active'
//     ];

//     protected $hidden = [
//         'deleted_at',
//     ];

//     public function countries()
//     {

//         return $this->hasMany(PromoCodeCountry::class, 'promo_code_id', 'id');
//     }
//     public function companies()
//     {

//         return $this->hasMany(PromoCodeCompany::class, 'promo_code_id', 'id');
//     }
// }
