<?php

namespace App\Models\DriversApp;

use App\Models\User;
use App\Http\Traits\ImagesTrait;
use App\Models\DriversApp\Client;
use App\Http\Traits\FileUploadTrait;
use App\Models\DriversApp\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    use FileUploadTrait;
    use ImagesTrait;

    public $timestamps = false;

    protected $table = 'drivers_app_orders';

    protected $primaryKey = 'order_id';

    protected $fillable = [

        'order_id','user_id',
        'delivery_type',
        'drivers_app_client_id' ,
    ];

    public function order()
    {
        return $this->belongsTo(\App\Models\Order::class, 'order_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function client(){

        return $this->belongsTo(Client::class,'drivers_app_client_id','id')->withTrashed();
    }

    public function items(){

        return $this->hasMany(OrderItem::class,'drivers_app_order_id','order_id');
    }

}
