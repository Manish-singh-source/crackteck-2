<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebhookEvent extends Model
{
    protected $fillable = [
        'gateway',
        'event_id',
        'event_type',
        'signature',
        'status',
        'processed_at',
        'headers',
        'payload',
    ];

    protected $casts = [
        'headers' => 'array',
        'processed_at' => 'datetime',
    ];
}
