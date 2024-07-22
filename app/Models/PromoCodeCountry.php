<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromoCodeCountry extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "promo_codes_countries";
    protected $fillable = ['country_id', 'promo_code_id'];
    public $timestamps = false;

    protected $hidden = [
        'deleted_at',
    ];
    
    public function country()
    {

        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function promoCode()
    {

        return $this->belongsTo(PromoCode::class, 'promo_code_id', 'id');
    }
}
