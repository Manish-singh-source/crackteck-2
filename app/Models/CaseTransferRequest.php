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

    public function serviceRequest()
    {
        return $this->belongsTo(\App\Models\ServiceRequest::class);
    }

    public function requestingEngineer()
    {
        return $this->belongsTo(\App\Models\Staff::class, 'requesting_engineer_id')
            ->where('staff_role', 'engineer');
    }

    public function engineer()
    {
        return $this->belongsTo(\App\Models\Staff::class, 'new_engineer_id');
    }

    public function coveredItems()
    {
        return $this->belongsTo(\App\Models\CoveredItem::class, 'diagnosis_list');
    }
}
