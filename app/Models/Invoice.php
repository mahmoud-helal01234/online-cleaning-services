<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [

        'order_id', 'payment_status', 'deleted_at'
    ];
    
    protected $hidden = ['deleted_at'];

    ////// WHEN DELETE INVOICE IT WILL DELETE ALL ITEMS :)
    protected static function booted()
    {

        static::deleting(function ($invoice) {
            $invoice->items()->delete();
        });
    }
    
    public function items()
    {

        return $this->hasMany(InvoiceItem::class, "invoice_id", "id");
    }

    public function order()
    {

        return $this->belongsTo(Order::class, "order_id", "id");
    }
}
