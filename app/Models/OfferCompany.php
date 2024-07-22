<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfferCompany extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "offers_companies";
    protected $fillable = ['company_id', 'offer_id'];
    public $timestamps = false;
    protected $hidden = ['deleted_at'];

    public function company()
    {

        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function offer()
    {

        return $this->belongsTo(Offer::class, 'offer_id', 'id');
    }
}
