<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Kyc extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'dob',
        'document_type',
        'document_file',
        'document_no',
        'role_id',
        'staff_id',
        'status',
        'reason',
        'approved_at',
        'rejected_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'dob' => 'date',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    /**
     * Status constants
     */
    const STATUS_PENDING = 'pending';

    const STATUS_SUBMITTED = 'submitted';

    const STATUS_UNDER_REVIEW = 'under_review';

    const STATUS_APPROVED = 'approved';

    const STATUS_REJECTED = 'rejected';

    const STATUS_RESUBMIT_REQUIRED = 'resubmit_required';

    /**
     * Document types constants
     */
    const DOCUMENT_AADHAR = 'aadhar';

    const DOCUMENT_PAN = 'pan';

    const DOCUMENT_DRIVING_LICENSE = 'driving_license';

    const DOCUMENT_POLICE_VERIFICATION_CERTIFICATE = 'police_verification_certificate';

    /**
     * Get all status options
     */
    public static function getStatusOptions()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_SUBMITTED => 'Submitted',
            self::STATUS_UNDER_REVIEW => 'Under Review',
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_REJECTED => 'Rejected',
            self::STATUS_RESUBMIT_REQUIRED => 'Resubmit Required',
        ];
    }

    /**
     * Get all document type options
     */
    public static function getDocumentTypeOptions()
    {
        return [
            self::DOCUMENT_AADHAR => 'Aadhar',
            self::DOCUMENT_PAN => 'PAN',
            self::DOCUMENT_DRIVING_LICENSE => 'Driving License',
            self::DOCUMENT_POLICE_VERIFICATION_CERTIFICATE => 'Police Verification Certificate',
        ];
    }

    /**
     * Approve the KYC
     */
    public function approve($reason = null)
    {
        $this->status = self::STATUS_APPROVED;
        $this->approved_at = now();
        $this->reason = $reason;
        $this->rejected_at = null;
        $this->save();
    }

    /**
     * Reject the KYC
     */
    public function reject($reason)
    {
        $this->status = self::STATUS_REJECTED;
        $this->rejected_at = now();
        $this->reason = $reason;
        $this->approved_at = null;
        $this->save();
    }

    /**
     * Mark as resubmit required
     */
    public function markResubmitRequired($reason)
    {
        $this->status = self::STATUS_RESUBMIT_REQUIRED;
        $this->reason = $reason;
        $this->approved_at = null;
        $this->rejected_at = null;
        $this->save();
    }

    /**
     * Submit the KYC
     */
    public function submit()
    {
        $this->status = self::STATUS_SUBMITTED;
        $this->save();
    }

    /**
     * Mark for review
     */
    public function markUnderReview()
    {
        $this->status = self::STATUS_UNDER_REVIEW;
        $this->save();
    }

    /**
     * Check if KYC is approved
     */
    public function isApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    /**
     * Check if KYC is rejected
     */
    public function isRejected()
    {
        return $this->status === self::STATUS_REJECTED;
    }

    /**
     * Check if KYC is pending
     */
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Get the document file URL
     */
    public function getDocumentFileUrlAttribute()
    {
        if ($this->document_file) {
            return asset('storage/'.$this->document_file);
        }

        return null;
    }

    /**
     * Get the staff member associated with this KYC
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    /**
     * Get the role associated with this KYC
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
