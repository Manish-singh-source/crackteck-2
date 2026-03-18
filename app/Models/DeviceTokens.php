<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceTokens extends Model
{
    //
    protected $fillable = [
        'user_id',
        'role_id',
        'device_type',
        'fcm_token',
        'device_id',
        'last_used_at',
    ];
}
