<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceTokens extends Model
{
    //
    protected $fillable = [
        'user_id',
        'owner_type',
        'role_id',
        'device_type',
        'firebase_project_id',
        'fcm_token',
        'device_id',
        'last_used_at',
    ];
}
