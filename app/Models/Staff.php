<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'staff_code',
        'staff_role',
        'first_name',
        'last_name',
        'phone',
        'email',
        'dob',
        'gender',
        'marital_status',
        'employment_type',
        'joining_date',
        'assigned_area',
        'status',
    ];

    public function address()
    {
        return $this->hasOne(StaffAddress::class);
    }

    public function bankDetails()
    {
        return $this->hasOne(StaffBankDetail::class);
    }

    public function workSkills()
    {
        return $this->hasOne(StaffWorkSkill::class);
    }

    public function aadharDetails()
    {
        return $this->hasOne(StaffAadharDetail::class);
    }

    public function panDetails()
    {
        return $this->hasOne(StaffPanCardDetail::class);
    }

    public function vehicleDetails()
    {
        return $this->hasOne(StaffVehicleDetail::class);
    }

    public function policeVerification()
    {
        return $this->hasOne(StaffPoliceVerification::class);
    }
}
