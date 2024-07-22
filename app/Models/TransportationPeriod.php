<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransportationPeriod extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [

        'user_id', 'from', 'to','created_at', 'updated_at', 'active'
    ];
    protected $hidden = ['deleted_at'];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function drivers()
    {
        return $this->hasMany(TransportationPeriodAssignedToDriver::class,'transportation_period_id','id');
    }

}
