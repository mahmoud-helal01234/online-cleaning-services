<?php

namespace App\Models;

use App\Models\Driver;
use App\Http\Traits\ImagesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientDriverRate extends Model
{
    use HasFactory, SoftDeletes;
    use FileUploadTrait;
    use ImagesTrait;

    public $timestamps = false;

    protected $fillable = ['client_id', 'driver_id', 'base_drivers_rates_id','value','active'];

    protected $table = "client_drivers_rates";
    protected $hidden = ['deleted_at'];


    public function driver(){

        return $this->belongsTo(Driver::class,'driver_id','user_id');
    }

    public function client(){

        return $this->belongsTo(Client::class,'client_id','id');
    }

    public function BaseDriversRate(){

        return $this->belongsTo(BaseDriverRate::class,'base_drivers_rates_id','id');
    }

}
