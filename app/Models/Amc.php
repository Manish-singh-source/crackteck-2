<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Amc extends Model
{
    use LogsActivity;
    //
    protected $fillable = [
        'request_id',
        'service_type',
        'amc_type',
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
        'payment_status',
        'payment_amount',
        'payment_currency',
        'paid_at',
        'created_by',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    /**
     * Configure activity logging options.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'request_id',
                'service_type',
                'amc_type',
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
                'payment_status',
                'payment_amount',
                'payment_currency',
                'paid_at',
                'created_by',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "AMC {$eventName}");
    }

    // start date 
    public function getStartDateAttribute()
    {
        return $this->created_at
            ? Carbon::parse($this->created_at)->format('d M Y')
            : null;
    }

    // end date
    public function getEndDateAttribute()
    {
        if (!$this->created_at || !$this->amcPlan?->duration) {
            return null;
        }

        $startDate = Carbon::parse($this->created_at);
        $duration = $this->amcPlan->duration;

        if ($duration > 0){
            return Carbon::parse($startDate->copy()->addMonths($duration))->format('d M Y');
        }

        return null;
    }


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

    public function remoteAmcPayments()
    {
        return $this->hasMany(RemoteAmcPayment::class);
    }
}
