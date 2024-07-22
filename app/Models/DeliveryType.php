<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryType extends Model
{

    use HasFactory,SoftDeletes;
    protected $fillable = [

        'name_ar', 'name_en', 'description_ar', 'description_en',
        'after_hours',
        'added_value_type',
        'added_value' ,
        'created_at',
        'updated_at',
        'active',
        'deleted_at'
    ];
    protected $hidden = ['deleted_at'];

}
