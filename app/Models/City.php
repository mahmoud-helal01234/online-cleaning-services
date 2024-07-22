<?php

namespace App\Models;

use App\Models\Governorate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'name_ar','name_en' ,	'governorate_id','active', 'created_at', 'updated_at','active'
    ];
    protected $hidden = [
        'deleted_at'
    ];
    public function governorate(){

        return $this->belongsTo(Governorate::class,'governorate_id','id');
    }
}
