<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [

        'id', 'order_id', 'product_option_id', 'name_en', 'name_ar', 'quantity', 'price'
    ];
    protected $hidden = ['deleted_at'];

    public $timestamps = false;


    public function order()
    {

        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
