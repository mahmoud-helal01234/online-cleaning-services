<?php

namespace App\Models;

use App\Models\Company;
use App\Http\Traits\ImagesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientCompanyRate extends Model
{
    use HasFactory, SoftDeletes;
    use FileUploadTrait;
    use ImagesTrait;

    public $timestamps = false;

    protected $fillable = ['client_id', 'company_id', 'base_companies_rate_id','value','active'];

    protected $table = "clients_companies_rates";

    protected $hidden = ['deleted_at'];

    public function company(){

        return $this->belongsTo(Company::class,'company_id','user_id');
    }

    public function client(){

        return $this->belongsTo(Client::class,'client_id','id');
    }

    public function BaseCompaniesRate(){

        return $this->belongsTo(BaseCompaniesRate::class,'base_companies_rate_id','id');
    }

}
