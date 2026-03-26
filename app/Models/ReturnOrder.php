<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnOrder extends Model
{
    use SoftDeletes;

    const STATUS_PENDING = 'pending';

    const STATUS_ASSIGNED = 'assigned';

    const STATUS_ACCEPTED = 'accepted';

    const STATUS_PICKED = 'picked';

    const STATUS_RECEIVED = 'received';

    const REFUND_STATUS_PENDING = 'pending';

    const REFUND_STATUS_PROCESSING = 'processing';

    const REFUND_STATUS_COMPLETED = 'completed';

    const REFUND_STATUS_FAILED = 'failed';

    const STATUS_OPTIONS = [
        self::STATUS_PENDING,
        self::STATUS_ASSIGNED,
        self::STATUS_ACCEPTED,
        self::STATUS_PICKED,
        self::STATUS_RECEIVED,
    ];

    const REFUND_STATUS_OPTIONS = [
        self::REFUND_STATUS_PENDING,
        self::REFUND_STATUS_PROCESSING,
        self::REFUND_STATUS_COMPLETED,
        self::REFUND_STATUS_FAILED,
    ];

    protected $fillable = [
        'return_order_number',
        'order_number',
        'order_item_id',
        'product_id',
        'customer_id',
        'return_person_id',
        'delivery_man_id',
        'status',
        'return_assigned_at',
        'return_accepted_at',
        'return_picked_at',
        'return_delivered_at',
        'otp',
        'otp_expiry',
        'otp_verified_at',
        'return_completed_at',
        'return_reason',
        'return_description',
        'return_images',
        'payment_method_snapshot',
        'customer_notes',
        'refund_amount',
        'refund_status',
        'refund_reference',
        'refund_notes',
        'admin_notes',
    ];

    protected $casts = [
        'return_assigned_at' => 'datetime',
        'return_accepted_at' => 'datetime',
        'return_picked_at' => 'datetime',
        'return_delivered_at' => 'datetime',
        'otp_verified_at' => 'datetime',
        'return_completed_at' => 'datetime',
        'otp_expiry' => 'datetime',
        'refund_amount' => 'decimal:2',
        'return_images' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($returnOrder) {
            if (empty($returnOrder->return_order_number)) {
                $returnOrder->return_order_number = self::generateReturnOrderNumber();
            }
        });
    }

    public static function generateReturnOrderNumber()
    {
        $prefix = 'RET';
        $date = date('Ymd');
        $random = strtoupper(substr(md5(uniqid()), 0, 6));

        return $prefix.'-'.$date.'-'.$random;
    }

    public function getStatusDisplayNameAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Pending',
            self::STATUS_ASSIGNED => 'Assigned',
            self::STATUS_ACCEPTED => 'Accepted',
            self::STATUS_PICKED => 'Picked',
            self::STATUS_RECEIVED => 'Received',
            default => 'Unknown',
        };
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'warning',
            self::STATUS_ASSIGNED => 'info',
            self::STATUS_ACCEPTED => 'primary',
            self::STATUS_PICKED => 'primary',
            self::STATUS_RECEIVED => 'success',
            default => 'secondary',
        };
    }

    public function getRefundStatusDisplayNameAttribute(): string
    {
        return match ($this->refund_status) {
            self::REFUND_STATUS_PENDING => 'Pending',
            self::REFUND_STATUS_PROCESSING => 'Processing',
            self::REFUND_STATUS_COMPLETED => 'Completed',
            self::REFUND_STATUS_FAILED => 'Failed',
            default => 'Unknown',
        };
    }

    public function getRefundStatusBadgeColorAttribute(): string
    {
        return match ($this->refund_status) {
            self::REFUND_STATUS_PENDING => 'warning',
            self::REFUND_STATUS_PROCESSING => 'info',
            self::REFUND_STATUS_COMPLETED => 'success',
            self::REFUND_STATUS_FAILED => 'danger',
            default => 'secondary',
        };
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function returnPerson()
    {
        return $this->belongsTo(Customer::class, 'return_person_id');
    }

    public function deliveryMan()
    {
        return $this->belongsTo(Staff::class, 'delivery_man_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_number', 'order_number');
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function refundBankDetails()
    {
        return $this->hasMany(RefundBankDetail::class);
    }

    public function canInitiateReturn(): bool
    {
        return in_array($this->status, [self::STATUS_PENDING]);
    }

    public function canVerifyOtp(): bool
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_ASSIGNED])
            && $this->otp
            && $this->otp_expiry
            && $this->otp_expiry->isFuture();
    }
}
