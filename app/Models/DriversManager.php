<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class DriversManager extends Model
{
    use HasFactory,SoftDeletes;
    public $timestamps = false;
    protected $table = "drivers_managers";
    protected $primaryKey = 'user_id';
    protected $hidden = ['deleted_at'];

    protected $fillable = ['user_id','country_id','deleted_at'];

    public function user(){

        return $this->belongsTo(User::class,'user_id','id');
    }
    public function country(){

        return $this->belongsTo(Country::class,'country_id','id');
    }

}
