<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemProductOption extends Model
{

    protected $table = "system_product_options";
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id', 'name_ar', 'name_en', 'system_product_id',    'created_at', 'updated_at', 'active'
    ];
    protected $hidden = ['deleted_at'];

    public function systemProduct()
    {
        return $this->belongsTo(SystemProduct::class, 'system_product_id', 'id');
    }
}
