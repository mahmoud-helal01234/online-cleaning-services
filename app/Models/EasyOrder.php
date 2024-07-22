<?php

namespace App\Models;

use App\Http\Traits\ImagesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class EasyOrder extends Model
{
    use HasFactory, SoftDeletes;
    use FileUploadTrait;
    use ImagesTrait;

    public $timestamps = false;

    protected $primaryKey = 'order_id';
    protected $fillable = [

        'order_id','content'
    ];
    protected $hidden = ['deleted_at'];

    public function order(){

        return $this->belongsTo(ClientOrder::class,'order_id','order_id');
    }

}
