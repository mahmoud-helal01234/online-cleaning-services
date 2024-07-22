<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderLocation extends Model
{

    use HasFactory;

    protected $fillable = [

        'order_id','driver_id', 'lat', 'long', 'status'
    ];
    protected $hidden = ['deleted_at'];

    public function driver()
    {

        return $this->belongsTo(Driver::class, 'driver_id', 'user_id');
    }

    public function stopPoint(){

        return $this->hasOne(OrderLocationStopPoint::class,'order_location_id','id');
    }

    public function order()
    {

        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
    const UPDATED_AT = null;

}
