<?php

namespace App\Models;

use App\Models\Invoice;
use App\Models\GeneralOffer;
use App\Http\Traits\ImagesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientGeneralOfferOrder extends Model
{

    use HasFactory, SoftDeletes;
    use FileUploadTrait;
    use ImagesTrait;

    protected $table = "client_general_offer_orders";

    protected $fillable = ['client_id', 'general_offer_id', 'content', 'status', 'invoice_id', 'active'];

    protected $hidden = ['deleted_at'];

    public function invoice()
    {

        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }

    public function generalOffer()
    {

        return $this->belongsTo(GeneralOffer::class, 'general_offer_id', 'id');
    }

    public function client()
    {

        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
}
