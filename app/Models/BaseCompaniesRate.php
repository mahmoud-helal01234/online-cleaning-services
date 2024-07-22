<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseCompaniesRate extends Model
{

    protected $table = "base_companies_rates";
    use HasFactory,SoftDeletes;

    protected $fillable = [

        'id', 'name_ar','name_en',	'created_at', 'updated_at','active'
    ];
    protected $hidden = ['deleted_at'];


}
