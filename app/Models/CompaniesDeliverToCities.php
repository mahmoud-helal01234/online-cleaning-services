<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompaniesDeliverToCities extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "companies_deliver_to_cities";
    protected $fillable = ['company_id', 'city_id',	'created_at'];
    public $timestamps = false;
    protected $hidden = ['deleted_at'];

    public function company(){

        return $this->belongsTo(Company::class,'company_id','user_id');
    }

    public function city(){

        return $this->belongsTo(City::class,'city_id','id');
    }
}
