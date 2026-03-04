<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Rappasoft\LaravelAuthenticationLog\Traits\AuthenticationLoggable;
use Spatie\Permission\Models\Role;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Staff extends Authenticatable implements JWTSubject
{
    use AuthenticationLoggable, HasFactory, Notifiable;

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
        'kyc_status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
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
