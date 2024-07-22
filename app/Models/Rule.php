<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rule extends Model
{
    //// THIS TABLE DOSN'T EXIST IN DATABASE BRUH
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title', 'desc', 'active'
    ];
    protected $hidden = ['deleted_at'];

}
