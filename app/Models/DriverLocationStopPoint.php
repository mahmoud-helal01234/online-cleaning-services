<?php

namespace App\Models;

use App\Models\DriverLocation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class DriverLocationStopPoint extends Model
{
 //// THIS WILL DELETED DAILY IF WE USE SOFT DELETES IT WILL BE A BIG DATA !!
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'driver_location_id';
    public $incrementing = false;

    protected $fillable = ['driver_location_id','to_at','reason'];

    public function driverLocation(){

        return $this->belongsTo(DriverLocation::class,'driver_location_id','id');
    }

}
