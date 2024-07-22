<?php

namespace App\Models;

use App\Models\Company;
use App\Models\DriversManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompaniesWorkingWithDriverManager extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "companies_working_with_drivers_managers";
    protected $fillable = ['company_id', 'drivers_manager_id', 'created_at'];
    public $timestamps = false;
    protected $hidden = ['deleted_at'];

    public function company()
    {

        return $this->belongsTo(Company::class, 'company_id', 'user_id');
    }

    public function driversManager()
    {

        return $this->belongsTo(DriversManager::class, 'drivers_manager_id', 'user_id');
    }
}
