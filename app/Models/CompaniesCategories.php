<?php

namespace App\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompaniesCategories extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = ['company_id', 'category_id'];
    protected $hidden = ['deleted_at'];

    protected $table = 'companies_categories';
    public $timestamps = false;

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function company(){

        return $this->belongsTo(Company::class,'company_id','user_id');
    }
}
