<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteVisit extends Model
{

    use HasFactory;

    protected $table = 'site_visits';
    protected $fillable = ['ip_address', 'city', 'region', 'country', 'browser', 'platform', 'latitude', 'longitude'];

}
