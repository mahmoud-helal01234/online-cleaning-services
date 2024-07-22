<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductOption extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id', 'name_ar', 'name_en', 'price_unit_ar', 'price_unit_en', 'price', 'product_id', 'created_at', 'updated_at'
    ];
    protected $hidden = ['deleted_at'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
