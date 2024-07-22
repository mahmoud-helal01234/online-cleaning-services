<?php

namespace App\Models;

use App\Http\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderComment extends Model
{

    use HasFactory, FileUploadTrait, SoftDeletes;

    protected $fillable = [

        'id','user_id', 'order_id', 'text', 'img_path','show_for_client'
    ];

    protected $hidden = ['deleted_at'];

    public $timestamps = false;

    public function setImgPathAttribute($value)
    {
        $this->attributes['img_path'] = $this->uploadFile($value,'images/order_comments', $this->attributes['img_path'] ?? "");
    }

    public function order()
    {

        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function user()
    {

        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
