<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $fillable = [
        'customer_code',
        'first_name',
        'last_name',
        'phone',
        'email',
        'dob',
        'gender',
        'customer_type',
        'source_type',
        'password',
        'status',
        'created_by',
    ];

    public function branches()
    {
        return $this->hasMany(CustomerAddressDetail::class);
    }

    public function aadharDetails()
    {
        return $this->hasOne(CustomerAadharDetail::class);
    }

    public function panCardDetails()
    {
        return $this->hasOne(CustomerPanCardDetail::class);
    }

    public function companyDetails()
    {
        return $this->hasOne(CustomerCompanyDetail::class);
    }

    // aadharDetail
    public function aadharDetail()
    {
        return $this->hasOne(CustomerAadharDetail::class);
    }

    // panCardDetail
    public function panCardDetail()
    {
        return $this->hasOne(CustomerPanCardDetail::class);
    }

    // addressDetails
    public function addressDetails()
    {
        return $this->hasMany(CustomerAddressDetail::class);
    }

    // companyDetail
    public function companyDetail()
    {
        return $this->hasOne(CustomerCompanyDetail::class);
    }
}
