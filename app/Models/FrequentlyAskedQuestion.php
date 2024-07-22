<?php

namespace App\Models;

use App\Http\Traits\ImagesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class FrequentlyAskedQuestion extends Model
{
    use HasFactory,SoftDeletes;
    use FileUploadTrait;
    use ImagesTrait;


    protected $fillable = [

       'id', 'question_ar', 'question_en', 'answer_ar', 'answer_en','active'
    ];
    protected $hidden = ['deleted_at'];



}
