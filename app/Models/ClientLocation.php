<?php

namespace App\Models;

use App\Http\Traits\ImagesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientLocation extends Model
{

    use HasFactory, SoftDeletes;
    use FileUploadTrait;
    use ImagesTrait;

    protected $fillable = [

        'client_id',
        'lat',
        'long',
        'phone_number',
        'telephone',
        'street',
        'building',
        'floor',
        'apartment',
        'additional_instructions',
        'detailed_address'
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function client(){

        return $this->belongsTo(Client::class,'client_id','id');
    }

}
