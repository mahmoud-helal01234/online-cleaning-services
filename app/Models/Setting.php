<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{


    use HasFactory, SoftDeletes;

    protected $fillable = [

        'id', 'min_order_price','first_order_cash_back_value', 'first_order_cash_back_value_type',
        'invitation_code_owner_cash_value', 'invitation_code_owner_cash_value_type',
        'invitation_code_user_cash_value', 'invitation_code_user_cash_value_type'
    ];
    protected $hidden = ['deleted_at'];

    public $timestamps = false;
}
