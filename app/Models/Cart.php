<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'ecommerce_product_id',
        'quantity'
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    /**
     * Get the user that owns the cart item.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the ecommerce product that belongs to the cart item.
     */
    public function ecommerceProduct()
    {
        return $this->belongsTo(EcommerceProduct::class, 'ecommerce_product_id');
    }

    /**
     * Scope to get cart items for a specific user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('customer_id', $userId);
    }

    /**
     * Check if a product is already in the user's cart.
     */
    public static function isInCart($userId, $productId)
    {
        return self::where('customer_id', $userId)
                   ->where('ecommerce_product_id', $productId)
                   ->exists();
    }

    /**
     * Get cart item for a specific user and product.
     */
    public static function getCartItem($userId, $productId)
    {
        return self::where('customer_id', $userId)
                   ->where('ecommerce_product_id', $productId)
                   ->first();
    }

    /**
     * Get total cart items count for a user.
     */
    public static function getCartCount($userId)
    {
        return self::where('customer_id', $userId)->sum('quantity');
    }

    /**
     * Get cart total amount for a user.
     */
    public static function getCartTotal($userId)
    {
        return self::with('ecommerceProduct.warehouseProduct')
                   ->where('customer_id', $userId)
                   ->get()
                   ->sum(function ($cartItem) {
                       // Ensure we have valid relationships and price
                       if (!$cartItem->ecommerceProduct || !$cartItem->ecommerceProduct->warehouseProduct) {
                           return 0;
                       }

                       $price = $cartItem->ecommerceProduct->warehouseProduct->selling_price ?? 0;
                       $price = is_numeric($price) ? (float)$price : 0;
                       $quantity = is_numeric($cartItem->quantity) ? (int)$cartItem->quantity : 0;

                       return $price * $quantity;
                   });
    }
}