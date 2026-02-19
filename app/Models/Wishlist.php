<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'ecommerce_product_id',
    ];

    /**
     * Get the user that owns the wishlist item.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the ecommerce product that belongs to the wishlist item.
     */
    public function ecommerceProduct()
    {
        return $this->belongsTo(EcommerceProduct::class, 'ecommerce_product_id');
    }

    /**
     * Check if a product is in the user's wishlist.
     */
    public static function isInWishlist($userId, $productId)
    {
        return self::where('customer_id', $userId)
                   ->where('ecommerce_product_id', $productId)
                   ->exists();
    }

    /**
     * Get wishlist item for a specific user and product.
     */
    public static function getWishlistItem($userId, $productId)
    {
        return self::where('customer_id', $userId)
                   ->where('ecommerce_product_id', $productId)
                   ->first();
    }
}
