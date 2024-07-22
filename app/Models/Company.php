<?php

namespace App\Models;

use App\Http\Traits\FileUploadTrait;
use App\Http\Traits\ImagesTrait;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;
    use FileUploadTrait;
    use ImagesTrait;

    public $timestamps = false;

    protected $primaryKey = 'user_id';

    protected $hidden = ['pivot', 'created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'user_id', 'orders_per_hour', 'logo_path', 'cover_path', 'name_ar', 'name_en','country_id'
    ];

    protected $attributes = [

        'orders_per_hour' => 4,
    ];

    public function setLogoPathAttribute($value)
    {
        $this->attributes['logo_path'] = $this->uploadFile($value, 'images/companies_logos', $this->attributes['logo_path'] ?? "");
    }

    public function setCoverPathAttribute($value)
    {
        $this->attributes['cover_path'] = $this->uploadFile($value, 'images/companies_logos', $this->attributes['cover_path'] ?? "");
    }

    // public function getLogoPathAttribute($value)
    // {
    //     return $this->imageUrl($value);
    // }

    public static function companiesWithoutCategory($category_id)
    {
        return self::whereDoesntHave('categories', function($query) use ($category_id) {
            $query->where('category_id', $category_id);
        })->get();
    }


    public function categories()
    {

        return $this->belongsToMany(Category::class, 'companies_categories', 'company_id', 'category_id');
    }

    public function user()
    {

        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function clientOrders(){

        return $this->hasMany(ClientOrder::class,'company_id','user_id');
    }
    public function offers(){

        return $this->belongsToMany(Offer::class,'offers_companies','offer_id','company_id');
    }
}
