<?php

namespace App\Models;

use App\Models\Driver;
use App\Models\DriverLocationStopPoint;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class DriverLocation extends Model
{
    use HasFactory;

    protected $fillable = [

        'driver_id', 'lat', 'long', 'created_at'
    ];
    protected $hidden = ['deleted_at'];


    public function stopPoint(){

        return $this->hasOne(DriverLocationStopPoint::class,'driver_location_id','id');
    }
    public function driver()
    {

        return $this->belongsTo(Driver::class, 'driver_id', 'user_id');
    }

    const UPDATED_AT = null;
}
