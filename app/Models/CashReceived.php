<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashReceived extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cash_received';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'staff_id',
        'order_id',
        'service_request_id',
        'amount',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'customer_id' => 'integer',
        'staff_id' => 'integer',
        'order_id' => 'integer',
        'service_request_id' => 'integer',
    ];

    /**
     * Status constants
     */
    const STATUS_CUSTOMER_PAID = 'customer_paid';
    const STATUS_RECEIVED = 'received';

    /**
     * Get the customer associated with this cash received entry.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the staff (Delivery Man / Engineer) who received the cash.
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    /**
     * Get the order associated with this cash received entry (if any).
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the service request associated with this cash received entry (if any).
     */
    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class, 'service_request_id');
    }

    /**
     * Get the order payment associated with this cash received entry.
     */
    public function orderPayment()
    {
        return $this->belongsTo(OrderPayment::class, 'order_id', 'order_id');
    }

    /**
     * Get the service request payment associated with this cash received entry.
     */
    public function serviceRequestPayment()
    {
        return $this->belongsTo(ServiceRequestPayment::class, 'service_request_id', 'service_request_id');
    }

    /**
     * Check if this is an order-based cash entry.
     */
    public function isOrderBased(): bool
    {
        return !is_null($this->order_id);
    }

    /**
     * Check if this is a service request-based cash entry.
     */
    public function isServiceRequestBased(): bool
    {
        return !is_null($this->service_request_id);
    }

    /**
     * Check if the status can be updated to received.
     */
    public function canMarkAsReceived(): bool
    {
        return $this->status === self::STATUS_CUSTOMER_PAID;
    }

    /**
     * Scope a query to only include customer_paid status.
     */
    public function scopeCustomerPaid($query)
    {
        return $query->where('status', self::STATUS_CUSTOMER_PAID);
    }

    /**
     * Scope a query to only include received status.
     */
    public function scopeReceived($query)
    {
        return $query->where('status', self::STATUS_RECEIVED);
    }

    /**
     * Scope a query to filter by staff.
     */
    public function scopeByStaff($query, $staffId)
    {
        return $query->where('staff_id', $staffId);
    }

    /**
     * Scope a query to filter by customer.
     */
    public function scopeByCustomer($query, $customerId)
    {
        return $query->where('customer_id', $customerId);
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }
}