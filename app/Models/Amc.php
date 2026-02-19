<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amc extends Model
{
    //
    protected $fillable = [
        'request_id',
        'service_type',
        'customer_id',
        'customer_address_id',
        'amc_plan_id',
        'otp',
        'otp_expiry',
        'visit_date',
        'reschedule_date',
        'request_date',
        'request_source',
        'status',
        'created_by'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function customerAddress()
    {
        return $this->belongsTo(CustomerAddressDetail::class, 'customer_address_id');
    }

    public function amcPlan()
    {
        return $this->belongsTo(AmcPlan::class, 'amc_plan_id');
    }

    public function amcProducts()
    {
        return $this->hasMany(AmcProduct::class, 'amc_id');
    }

    public function amcScheduleMeetings()
    {
        return $this->hasMany(AmcScheduleMeeting::class, 'amc_id');
    }

}
