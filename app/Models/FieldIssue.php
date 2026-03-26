<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldIssue extends Model
{
    //
    protected $fillable = [
        'issue_id',
        'field_executive_id',
        'service_request_id',
        'service_request_product_id',
        'issue_type',
        'issue_description',
        'priority',
        'status',
        'assigned_remote_engineer_id',
        'resolved_at',
        'resolution_notes',
        'attachments',
    ];

    protected $casts = [
        'attachments' => 'array',
    ];


    // Staff Details
    public function staff() {
        return $this->hasOne(Staff::class, 'id', 'field_executive_id');
    }

    public function serviceRequest() {
        return $this->hasOne(ServiceRequest::class, 'id', 'service_request_id'); 
    }

    public function serviceRequestProduct() {
        return $this->hasOne(ServiceRequestProduct::class, 'id', 'service_request_product_id');
    }
}
