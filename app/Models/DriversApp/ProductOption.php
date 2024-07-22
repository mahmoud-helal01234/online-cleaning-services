<?php

namespace App\Models\DriversApp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductOption extends Model
{

    use HasFactory, SoftDeletes;

    protected $table = "drivers_app_product_options";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [

        'drivers_app_product_id',
        'name',
        'price'
    ];
    public $timestamps = false;



}
