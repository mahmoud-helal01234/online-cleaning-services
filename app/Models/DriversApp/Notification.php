<?php

namespace App\Models\DriversApp;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'drivers_app_order_id', 'order_id', 'user_id', 'title_ar', 'title_en', 'body_ar', 'body_en', 'action', 'action_data', 'created_at'
    ];
    protected $casts = [
        'action_data' => 'json',
    ];

    /**
     * The roles that belong to the Notification
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'drivers_app_users_notifications', 'user_id', 'id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
    
}
