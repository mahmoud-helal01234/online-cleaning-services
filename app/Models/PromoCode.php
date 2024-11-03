<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromoCode extends Model
{

    use HasFactory;
    // , SoftDeletes;

    protected $fillable = [
       'id','code', 'active', 'value', 'discount_type', 'max_fixed_value'
    ];

    // protected $hidden = [
    //     'deleted_at',
    // ];

    public function orders()
    {

        return $this->hasMany(Order::class, 'promo_code_id', 'id');
    }

}
