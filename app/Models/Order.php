<?php

namespace App\Models;

use App\Http\Traits\ImagesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Exceptions\HttpResponseException;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    use FileUploadTrait;
    use ImagesTrait;

    protected $fillable = [

        'id',
        'status',
        'special_instructions',
        'pickup_driver_id',
        'delivery_driver_id',
        'price',
        'client_id',
        'location_id'

    ];

    protected $hidden = ['deleted_at'];

    public function location()
    {

        return $this->belongsTo(ClientLocation::class, 'location_id', 'id');
    }

    public function deliveryDriver()
    {

        return $this->belongsTo(User::class, 'delivery_driver_id', 'id');
    }

    public function pickupDriver()
    {

        return $this->belongsTo(User::class, 'pickup_driver_id', 'id');
    }

    public function items()
    {

        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function client()
    {

        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

}
