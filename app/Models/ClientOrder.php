<?php

namespace App\Models;

use App\Models\Company;
use App\Http\Traits\ImagesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientOrder extends Model
{
    use HasFactory, SoftDeletes;
    use FileUploadTrait;
    use ImagesTrait;


    protected $fillable = [

        'order_id',
        'type',
        'client_id',
        'company_id',
        'delivery_type_id',
        'client_location_id',
        'invoice_id',
        'promo_code_id'
    ];
    protected $primaryKey =
        'order_id';

    public $timestamps = false;
    protected $hidden = ['deleted_at'];

    public function order()
    {

        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function client()
    {

        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function clientLocation()
    {

        return $this->belongsTo(ClientLocation::class, 'client_location_id', 'id');
    }

    public function company()
    {

        return $this->belongsTo(Company::class, 'company_id', 'user_id');
    }

    public function deliveryType()
    {

        return $this->belongsTo(DeliveryType::class, 'delivery_type_id', 'id');
    }

    public function invoice()
    {

        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }

    public function promoCode()
    {

        return $this->belongsTo(PromoCode::class, 'promo_code_id', 'id');
    }
    public function rate()
    {
        return $this->hasMany(OrderHaveBaseOrdersRate::class, 'order_id', 'order_id');
    }

}
