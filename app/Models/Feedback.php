<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    //
    protected $table = 'feedback';
    protected $fillable = [
        'customer_id',
        'service_id',
        'service_type',
        'rating',
        'comments',
    ];

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class, 'service_id', 'id');
    }
}
