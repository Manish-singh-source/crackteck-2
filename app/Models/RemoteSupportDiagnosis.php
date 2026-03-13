<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RemoteSupportDiagnosis extends Model
{
    //
    protected $fillable = [
        'remote_support_job_id',
        'service_request_product_id',
        'client_connected_via',
        'client_confirmation', 
        'remote_tool',
        'diagnosis_list',
        'fix_description',
        'before_screenshots',
        'after_screenshots',
        'logs',
        'time_spent',
        'client_feedback',
        'status',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function remoteSupportJob() {
        return $this->belongsTo(RemoteSupportJob::class, 'remote_support_job_id', 'id');
    }
}
