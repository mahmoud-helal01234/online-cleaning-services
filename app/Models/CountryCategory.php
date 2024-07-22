<?php

namespace App\Models;

use App\Models\Country;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CountryCategory extends Model
{

    use HasFactory, SoftDeletes;
    protected $fillable = ['country_id', 'category_id'];

    protected $table = 'categories_countries';

    protected $hidden = ['deleted_at'];
    public $timestamps = false;

    public function category(){

        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function country(){

        return $this->belongsTo(Country::class,'country_id','id');
    }
}
