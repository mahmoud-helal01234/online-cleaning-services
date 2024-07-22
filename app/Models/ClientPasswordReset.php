<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientPasswordReset extends Model
{

    protected $table = "clients_password_resets";
    use HasFactory;
    const UPDATED_AT = null;
    public $incrementing = false;
    protected $primaryKey =
    'client_id'
    ;
    protected $fillable = [

        'client_id', 'token','created_at'
    ];
    protected $hidden = ['deleted_at'];

    public function client(){

        return $this->belongsTo(Client::class,"client_id","id");
    }

}
