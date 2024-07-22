<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransportationPeriodAssignedToDriver extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "transportation_periods_assigned_to_drivers";

    protected $fillable = [

       'id','driver_id', 'transportation_period_id', 'capacity'
    ];
    protected $hidden = ['deleted_at'];


    public function driver()
    {

        return $this->belongsTo(Driver::class, 'driver_id', 'user_id');
    }

    public function transportationPeriod()
    {

        return $this->belongsTo(TransportationPeriod::class, 'transportation_period_id', 'id');
    }



}
