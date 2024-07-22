<?php

namespace App\Models;

use App\Http\Traits\ImagesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class WalletHistory extends Model
{
    use HasFactory, SoftDeletes;
    use FileUploadTrait;
    use ImagesTrait;

    protected $table = "wallet_history";

    protected $fillable = [

        'id', 'client_id', 'content', 'active'
    ];
    protected $hidden = ['deleted_at'];

    public function client()
    {

        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
}
