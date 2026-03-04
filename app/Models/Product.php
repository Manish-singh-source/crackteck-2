<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'vendor_id',
        'vendor_purchase_order_id',
        'brand_id',
        'parent_category_id',
        'sub_category_id',
        'warehouse_id',

        'product_name',
        'hsn_code',
        'sku',
        'model_no',
        'short_description',
        'full_description',
        'technical_specification',
        'brand_warranty',
        'company_warranty',

        'cost_price',
        'selling_price',
        'discount_price',
        'tax',
        'final_price',

        'stock_quantity',
        'stock_status',

        'main_product_image',
        'additional_product_images',
        'datasheet_manual',

        'variation_options',
        'status',
    ];

    protected $casts = [
        'additional_product_images' => 'array',
        'variation_options' => 'array',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function parentCategorie()
    {
        return $this->belongsTo(ParentCategory::class, 'parent_category_id');
    }

    public function subCategorie()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function warehouseRack()
    {
        return $this->belongsTo(WarehouseRack::class);
    }

    public function productSerials()
    {
        return $this->hasMany(ProductSerial::class)->orderBy('id', 'desc');
    }

    public function productVariantAttributes()
    {
        return $this->hasMany(ProductVariantAttribute::class);
    }

    public function productVariantAttributeValues()
    {
        return $this->hasMany(ProductVariantAttributeValue::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function vendorPurchaseOrder()
    {
        return $this->belongsTo(VendorPurchaseOrder::class, 'vendor_purchase_order_id');
    }

    public function ecommerceProduct()
    {
        return $this->hasOne(EcommerceProduct::class, 'product_id');
    }
}
