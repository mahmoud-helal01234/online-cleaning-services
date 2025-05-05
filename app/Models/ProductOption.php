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
        'id', 'price', 'option_id',  'product_id', 'created_at', 'updated_at'
    ];
    protected $hidden = ['deleted_at'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function option()
    {

        return $this->belongsTo(Option::class, 'option_id', 'id');
    }

}
