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


    public function setGenderAttribute($value)
    {
        $map = [
            'male' => 1,
            'female' => 2,
            'other' => 3,
        ];

        $this->attributes['gender'] = is_numeric($value)
            ? $value
            : ($map[strtolower($value)] ?? null);
    }

    public function setCustomerTypeAttribute($value)
    {
        $map = [
            'e-commerce' => 0,
            'amc' => 1,
            'non-amc' => 2,
            'both' => 3,
            'offline' => 4,
        ];

        $this->attributes['customer_type'] = is_numeric($value)
            ? $value
            : ($map[strtolower($value)] ?? null);
    }

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
