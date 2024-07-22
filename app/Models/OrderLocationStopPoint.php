<?php

namespace App\Models;

use App\Models\OrderLocation;
use App\Models\DriverLocation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class OrderLocationStopPoint extends Model
{
 //// THIS WILL DELETED DAILY IF WE USE SOFT DELETES IT WILL BE A BIG DATA !!
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'order_location_id';
    public $incrementing = false;

    protected $fillable = ['order_location_id','to_at','reason'];

    public function orderLocation(){

        return $this->belongsTo(OrderLocation::class,'order_location_id','id');
    }

}
