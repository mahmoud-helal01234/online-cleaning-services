<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use HasFactory,SoftDeletes;

    public $timestamps = false;

    protected $primaryKey = 'user_id';
    protected $hidden = ['pivot', 'deleted_at'];
    protected $fillable = ['user_id', 'manager_id'];

    public function user() {

        return $this->belongsTo(User::class,'user_id','id');
    }
    public function manager() {

        return $this->belongsTo(User::class,'manager_id','id');
    }

}
