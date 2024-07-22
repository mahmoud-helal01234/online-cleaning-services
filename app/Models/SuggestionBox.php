<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuggestionBox extends Model
{

    protected $table = "suggestion_box";
    use HasFactory;

    protected $fillable = [

        'id','content'
    ];


}
