<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Option extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id', 'name_ar', 'name_en', 'created_at', 'updated_at'
    ];
    protected $hidden = ['deleted_at'];

    public function productOption()
    {
        return $this->belongsTo(ProductOption::class, 'product_id', 'id');
    }
}
