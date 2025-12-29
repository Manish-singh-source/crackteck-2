<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketComment extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'ticket_id',
        'created_by',
        'comment',
        'attachments',
        'is_internal',
    ];

    protected $casts = [
        'attachments' => 'array',
    ];
}
