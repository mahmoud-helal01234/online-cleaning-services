<?php

namespace App\Models;

use App\Http\Traits\ImagesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory,SoftDeletes;
    use FileUploadTrait;
    use ImagesTrait;

    protected $fillable = [
        'name_ar','name_en' , 'img_path','active',	'created_at', 'updated_at','active','deleted_at'
    ];
    protected $hidden = [
        'deleted_at'
    ];
    // protected static function booted()
    // {
    //     static::deleting(function ($country) {
    //         //// MAKE A FLAG TO MAKE SURE IN THE governorates IS DELETING FROM THE COUNTRY
    //         //$country->setAttribute('deletingGovernorate', true); // Set the flag
    //         // FLAG DOSNT WORK BRUH :'( WE USE REQUEST TO ASK IF THE DELETION IS HAPPENING AT THE GOVERNORATE LEVEL OR AT THE COUNTRY LEVEL .
    //         //dd($country->deletingGovernorate);
    //         //  (request()->is('*/country/*')) {
    //             // $country->governorates()->each(function ($governate) {
    //             $country->governorates()->delete();

    //         //     });
    //         // }
    //         //$country->unsetAttribute('deletingGovernorate');
    //     });
    // }
    public function setImgPathAttribute($value)
    {
        $this->attributes['img_path'] = $this->uploadFile($value,'images/countries', $this->attributes['img_path'] ?? "");
    }


    public function governorates(){
        return $this->hasMany(Governorate::class,'country_id','id');
    }

}
