<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceItem extends Model
{

    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'invoice_items';
    
    protected $fillable = [

        'name_ar','name_en', 'price', 'quantity', 'invoice_id'
    ];
    protected $hidden = ['deleted_at'];

    public $timestamps = false;


}
