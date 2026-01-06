<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseTransferRequest extends Model
{
    use SoftDeletes;

    //
    protected $fillable = [
        'transfer_id', 
        'service_request_id',
        'requesting_engineer_id',
        'new_engineer_id',
        'engineer_reason',
        'admin_reason',
        'status',
        'approved_at',
        'rejected_at',
    ];
}
