<?php

namespace App\Models\DriversApp;

use App\Models\DriversApp\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{

    use HasFactory,SoftDeletes;

    protected $table = 'drivers_app_order_items';

    protected $fillable = [

        'id', 'drivers_app_order_id', 'name', 'quantity' , 'price'
    ];


    public $timestamps = false;


    public function order()
    {

        return $this->belongsTo(Order::class, 'driver_app_orders_id', 'id');
    }
}
