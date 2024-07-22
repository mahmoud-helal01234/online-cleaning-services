<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TermsAndConditions extends Model
{

    protected $table = "terms_and_conditions";
    use HasFactory, SoftDeletes;

    protected $fillable = [

        'id', 'title_ar', 'title_en', 'description_ar', 'description_en', 'active'
    ];
    protected $hidden = ['deleted_at'];

    public $timestamps = false;
}
