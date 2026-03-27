<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderFeedback extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'order_feedback';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'customer_id',
        'feedback',
        'star',
        'status',
        'media',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'star' => 'integer',
        'media' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Status constants
     */
    const STATUS_INACTIVE = 'inactive';
    const STATUS_ACTIVE = 'active';

    /**
     * Get the order that owns the feedback.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Get the ecommerce product that owns the feedback.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(EcommerceProduct::class, 'product_id');
    }

    /**
     * Get the customer that owns the feedback.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get all media files for the feedback.
     */
    public function getMediaAttribute($value): array
    {
        if (is_array($value)) {
            return $value;
        }

        if (is_string($value) && $value !== '') {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }

    /**
     * Get only images for the feedback.
     */
    public function getImagesAttribute(): array
    {
        $media = $this->media;
        return array_filter($media, function ($item) {
            return ($item['file_type'] ?? null) === 'image';
        });
    }

    /**
     * Get only videos for the feedback.
     */
    public function getVideosAttribute(): array
    {
        $media = $this->media;
        return array_filter($media, function ($item) {
            return ($item['file_type'] ?? null) === 'video';
        });
    }

    /**
     * Scope to get only active feedback.
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope to get only inactive feedback.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }

    /**
     * Scope to get feedback for a specific product.
     */
    public function scopeForProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    /**
     * Scope to get feedback for a specific order.
     */
    public function scopeForOrder($query, $orderId)
    {
        return $query->where('order_id', $orderId);
    }

    /**
     * Scope to get feedback by a specific customer.
     */
    public function scopeByCustomer($query, $customerId)
    {
        return $query->where('customer_id', $customerId);
    }

    /**
     * Check if feedback is active.
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Check if feedback is inactive.
     */
    public function isInactive(): bool
    {
        return $this->status === self::STATUS_INACTIVE;
    }

    /**
     * Get the star rating display.
     */
    public function getStarRatingDisplayAttribute(): string
    {
        return str_repeat('★', $this->star) . str_repeat('☆', 5 - $this->star);
    }

    /**
     * Get the status badge color.
     */
    public function getStatusBadgeColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_ACTIVE => 'success',
            self::STATUS_INACTIVE => 'warning',
            default => 'secondary',
        };
    }

    /**
     * Get the status display name.
     */
    public function getStatusDisplayNameAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
            default => 'Unknown',
        };
    }
}
