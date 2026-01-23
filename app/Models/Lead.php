<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lead extends Model
{
    use HasFactory;

    //
    protected $fillable = [
        'customer_id',
        'staff_id',
        'lead_number',
        'first_name',
        'last_name',
        'phone',
        'email',
        'dob',
        'gender',
        'company_name',
        'designation',
        'industry_type',
        'source',
        'requirement_type',
        'budget_range',
        'urgency',
        'status',
        'estimated_value',
        'notes',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function customerAddress()
    {
        return $this->belongsTo(CustomerAddressDetail::class, 'customer_address_id');
    }

    public function companyDetails()
    {
        return $this->belongsTo(CustomerCompanyDetail::class, 'customer_id');
    }
}
