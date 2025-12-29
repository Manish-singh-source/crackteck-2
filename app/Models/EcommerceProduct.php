<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EcommerceProduct extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'sku',
        'with_installation',
        'company_warranty',
        'short_description',
        'full_description',
        'technical_specification',
        'min_order_qty',
        'max_order_qty',
        'shipping_charges',
        'shipping_class',
        'variation_options',
        'is_featured',
        'is_best_seller',
        'is_suggested',
        'is_todays_deal',
        'product_tags',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_product_url_slug',
    ];

    protected $casts = [
        'additional_product_images' => 'array',
        'variation_options' => 'array',
        'with_installation' => 'array',
        'product_tags' => 'array',
        'is_featured' => 'boolean',
        'is_best_seller' => 'boolean',
        'is_suggested' => 'boolean',
        'is_todays_deal' => 'boolean',
        'shipping_charges' => 'decimal:2',
    ];

    public function warehouseProduct()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

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
}
