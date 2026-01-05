<?php

namespace App\Models;

use Spatie\Permission\Models\Role;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Authenticatable implements JWTSubject
{
    use HasFactory;
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

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

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

    public function setMaritalStatusAttribute($value)
    {
        $map = [
            'unmarried' => 1,
            'married' => 2,
            'divorced' => 3,
        ];

        $this->attributes['marital_status'] = is_numeric($value)
            ? $value
            : ($map[strtolower($value)] ?? null);
    }
    
    public function setEmploymentTypeAttribute($value)
    {
        $map = [
            'full_time' => 1,
            'part_time' => 2,
            'contractual' => 3,
        ];

        $this->attributes['employment_type'] = is_numeric($value)
            ? $value
            : ($map[strtolower($value)] ?? null);
    }
    
    
    public function setStatusAttribute($value)
    {
        $map = [
            'active' => 1,
            'inactive' => 2,
            'suspended' => 3,
        ];

        $this->attributes['status'] = is_numeric($value)
            ? $value
            : ($map[strtolower($value)] ?? null);
    }
    

    // Get Role 
    public function role()
    {
        return $this->belongsTo(Role::class, 'staff_role');
    }

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
