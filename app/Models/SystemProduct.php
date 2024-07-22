<?php

namespace App\Models;

use App\Http\Traits\ImagesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemProduct extends Model
{
    use HasFactory, SoftDeletes;
    use FileUploadTrait;
    use ImagesTrait;

     ////// WHEN DELETE PRODUCT IT WILL DELETE ALL OPTION :)
     protected static function booted(){

        static::deleting(function($systemProduct){
            $systemProduct->options()->delete();
        });
    }
    //////////////////////////
    protected $fillable = [
        'category_id',    'name_ar', 'name_en',    'img_path',    'created_at',    'updated_at', 'active'
    ];

    protected $hidden = ['deleted_at'];

    public function setImgPathAttribute($value)
    {
        $this->attributes['img_path'] = $this->uploadFile($value, 'images/products', $this->attributes['img_path'] ?? "");
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function options()
    {
        return $this->hasMany(SystemProductOption::class, 'system_product_id', 'id');
    }
}
