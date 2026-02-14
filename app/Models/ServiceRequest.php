<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    //
    protected $casts = [
        'request_date' => 'date',
    ];

    protected $fillable = [
        'request_id',
        // 'item_code_id',
        'service_type',
        'customer_id',
        'customer_address_id',
        'request_date',
        'request_status',
        'request_source',   
        'visit_date',
        'reschedule_date',
        'created_by',   
        'is_engineer_assigned',
        'status',
        'amc_plan_id',
        'otp',
        'otp_expiry'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function customerAddress()
    {
        return $this->belongsTo(CustomerAddressDetail::class, 'customer_id', 'customer_id');
    }

    public function customerCompany()
    {
        return $this->belongsTo(CustomerCompanyDetail::class, 'customer_id', 'customer_id');
    }

    public function customerPan()
    {
        return $this->belongsTo(CustomerPanCardDetail::class, 'customer_id', 'customer_id');
    }

    public function products()
    {
        return $this->hasMany(ServiceRequestProduct::class, 'service_requests_id');
    }

    public function parentCategorie()
    {
        return $this->belongsTo(ParentCategory::class, 'parent_category_id');
    }

    public function parentCategory()
    {
        return $this->belongsTo(ParentCategory::class, 'type');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand');
    }

    public function quickService()
    {
        return $this->belongsTo(CoveredItem::class, 'item_code_id');
    }

    public function amcPlan()
    {
        return $this->belongsTo(AmcPlan::class, 'amc_plan_id');
    }

    public function assignedEngineers()
    {
        return $this->hasMany(AssignedEngineer::class);
    }

    public function activeAssignment()
    {
        return $this->hasOne(AssignedEngineer::class)->where('status', 'active')->latest();
    }

    public function inactiveAssignments()
    {
        return $this->hasMany(AssignedEngineer::class)->where('status', 'inactive')->orderBy('created_at', 'desc');
    }

    public function quotations()
    {
        return $this->hasMany(ServiceRequestQuotation::class, 'request_id');
    }

    /**
     * Get the product returns for this service request.
     */
    public function productReturns()
    {
        return $this->hasMany(ServiceRequestProductReturn::class, 'request_id');
    }

    //  
    public function amcScheduleMeetings() {
        return $this->hasMany(AmcScheduleMeeting::class, 'service_request_id');
    }
}
