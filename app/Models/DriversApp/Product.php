<?php

namespace App\Models\DriversApp;

use App\Http\Traits\ImagesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{

    use HasFactory, SoftDeletes;
    use FileUploadTrait;
    use ImagesTrait;

    protected $table = "drivers_app_products";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [

        'user_id',
        'name',
        'img_path'
    ];

    public function setImgPathAttribute($value)
    {
        $this->attributes['img_path'] = $this->uploadFile($value,'images/drivers_app_products', $this->attributes['img_path'] ?? "");
    }

    public function productOptions(){

        return $this->hasMany(ProductOption::class,"drivers_app_product_id","id");
    }



}
