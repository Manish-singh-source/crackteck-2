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
        'customer_address_id',
        'lead_number',
        'requirement_type',
        'budget_range',
        'urgency',
        'estimated_value',
        'status',
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

    public function quotation()
    {
        return $this->hasOne(Quotation::class, 'lead_id');
    }
}
