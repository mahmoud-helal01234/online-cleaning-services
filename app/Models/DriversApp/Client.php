<?php

namespace App\Models\DriversApp;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ResponsesTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use  HasFactory, Notifiable,SoftDeletes;
    use ResponsesTrait;
    protected $table = 'drivers_app_clients';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [

        'id',
        'user_id',
        'name',
        'phone',
        'address',
        'lat',
        'long',
        'deleted_at'
    ];




}
