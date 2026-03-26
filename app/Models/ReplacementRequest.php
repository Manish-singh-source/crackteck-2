<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReplacementRequest extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_ASSIGNED = 'assigned';
    public const STATUS_COMPLETED = 'completed';

    protected $fillable = [
        'request_number',
        'order_id',
        'order_item_id',
        'customer_id',
        'original_product_id',
        'replacement_product_id',
        'reason',
        'description',
        'status',
        'admin_notes',
        'assigned_person_type',
        'assigned_person_id',
        'approved_at',
        'rejected_at',
        'assigned_at',
        'completed_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'assigned_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $request) {
            if (empty($request->request_number)) {
                $request->request_number = 'REP-' . now()->format('Ymd') . '-' . strtoupper(substr(md5(uniqid('', true)), 0, 6));
            }
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function originalProduct()
    {
        return $this->belongsTo(Product::class, 'original_product_id');
    }

    public function replacementProduct()
    {
        return $this->belongsTo(EcommerceProduct::class, 'replacement_product_id');
    }

    public function assignedPerson()
    {
        return $this->belongsTo(Staff::class, 'assigned_person_id');
    }
}
