<?php

namespace App\Models;

use App\Models\PromoCode;
use App\Http\Traits\ImagesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'location_id',
        'paid',
        'client_name',
        'phone',
        'address',
        'preferred_pickup_time',
        'promo_code_id'
    ];
   

    protected $hidden = ['deleted_at'];

    public function location()
    {

        return $this->belongsTo(ClientLocation::class, 'location_id', 'id')->withTrashed();
    }

    public function deliveryDriver()
    {

        return $this->belongsTo(User::class, 'delivery_driver_id', 'id')->withTrashed();
    }

    public function pickupDriver()
    {

        return $this->belongsTo(User::class, 'pickup_driver_id', 'id')->withTrashed();
    }

    public function items()
    {

        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function client()
    {

        return $this->belongsTo(Client::class, 'client_id', 'id')->withTrashed();
    }


    public function promoCode()
    {

        return $this->belongsTo(PromoCode::class, 'promo_code_id', 'id');
    }

}
