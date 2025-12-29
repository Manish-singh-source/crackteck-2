<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'ticket_number',
        'ticket_id',
        'title',
        'description',
        'category',
        'subcategory',
        'priority',
        'status',
        'assigned_to',
        'response_time_minutes',
        'resolution_time_minutes',
        'first_response_at',
        'resolved_at',
    ];
}
