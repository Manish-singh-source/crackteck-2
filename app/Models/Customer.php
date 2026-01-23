<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable implements JWTSubject
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
        'is_lead',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
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

    // addressDetails
    public function addressDetails()
    {
        return $this->hasMany(CustomerAddressDetail::class);
    }

    // primary address only 
    public function primaryAddress()
    {
        return $this->hasOne(CustomerAddressDetail::class)->where('is_primary', 'yes');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}
