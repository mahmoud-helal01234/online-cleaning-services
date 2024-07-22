<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromoCodeCompany extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "promo_codes_companies";
    protected $fillable = ['company_id', 'promo_code_id'];

    protected $hidden = [
        'deleted_at',
    ];
    public $timestamps = false;

    public function company()
    {

        return $this->belongsTo(Company::class, 'company_id', 'user_id');
    }

    public function promoCode()
    {

        return $this->belongsTo(PromoCode::class, 'promo_code_id', 'id');
    }
}
