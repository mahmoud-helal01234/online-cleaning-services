<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderHaveBaseOrdersRate extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "orders_have_base_orders_rates";
    protected $fillable = ['order_id', 'base_orders_rate_id', 'value'];
    protected $hidden = ['deleted_at'];


    public function order()
    {

        return $this->belongsTo(ClientOrder::class, 'order_id', 'id');
    }

    public function baseOrdersRate()
    {

        return $this->belongsTo(BaseOrdersRate::class, 'base_orders_rate_id', 'id');
    }
}
