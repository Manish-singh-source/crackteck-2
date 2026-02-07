<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_serial_id',
        'product_name',
        'product_sku',
        'hsn_code',
        'quantity',
        'unit_price',
        'discount_per_unit',
        'tax_per_unit',
        'line_total',
        'variant_details',
        'custom_options',
        'item_status',
    ];

    protected $casts = [
        'variant_details' => 'array',
        'custom_options' => 'array',
    ];

    /**
     * Create an order item from a product (for buy now checkout).
     */
    public static function createFromProduct($product, $quantity, $orderId)
    {
        $warehouseProduct = $product->warehouseProduct;
        
        $unitPrice = $warehouseProduct->final_price ?? $warehouseProduct->selling_price ?? 0;
        $lineTotal = $unitPrice * $quantity;
        $taxPerUnit = $warehouseProduct->tax ?? 0;
        
        return self::create([
            'order_id' => $orderId,
            'product_id' => $warehouseProduct->id,
            'product_serial_id' => null,
            'product_name' => $warehouseProduct->product_name,
            'product_sku' => $warehouseProduct->sku ?? null,
            'hsn_code' => $warehouseProduct->hsn_code ?? null,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'discount_per_unit' => 0,
            'tax_per_unit' => $taxPerUnit,
            'line_total' => $lineTotal,
            'variant_details' => null,
            'custom_options' => null,
            'item_status' => 'pending',
        ]);
    }

    /**
     * Create an order item from a cart item.
     */
    public static function createFromCartItem($cartItem, $orderId)
    {
        $product = $cartItem->ecommerceProduct;
        $warehouseProduct = $product->warehouseProduct;
        
        $unitPrice = $warehouseProduct->final_price ?? $warehouseProduct->selling_price ?? 0;
        $lineTotal = $unitPrice * $cartItem->quantity;
        $taxPerUnit = $warehouseProduct->tax ?? 0;
        
        return self::create([
            'order_id' => $orderId,
            'product_id' => $warehouseProduct->id,
            'product_serial_id' => null,
            'product_name' => $warehouseProduct->product_name,
            'product_sku' => $warehouseProduct->sku ?? 'SKU-' . $warehouseProduct->id,
            'hsn_code' => $warehouseProduct->hsn_code ?? null,
            'quantity' => $cartItem->quantity,
            'unit_price' => $unitPrice,
            'discount_per_unit' => 0,
            'tax_per_unit' => $taxPerUnit,
            'line_total' => $lineTotal,
            'variant_details' => null,
            'custom_options' => null,
            'item_status' => 'pending',
        ]);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function ecommerceProduct()
    {
        return $this->belongsTo(EcommerceProduct::class);
    }
    
    public function productSerial()
    {
        return $this->belongsTo(ProductSerial::class);
    }
}
