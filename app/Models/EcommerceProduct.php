<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Honeystone\Seo\MetadataDirector;

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
        'weight',
        'dimensions',
        'shipping_time',
        'cod',
        'variation_options',
        'is_featured',
        'is_best_seller',
        'is_suggested',
        'is_todays_deal',
        'is_returnable',
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
        'product_tags' => 'array',
        'is_featured' => 'boolean',
        'is_best_seller' => 'boolean',
        'is_suggested' => 'boolean',
        'is_todays_deal' => 'boolean',
        'is_returnable' => 'boolean',
        'cod' => 'boolean',
        'shipping_charges' => 'decimal:2',
        'weight' => 'decimal:2',
    ];

    public function warehouseProduct()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }


    public function seo(): MetadataDirector
    {
        $title = $this->meta_title ?: $this->warehouseProduct?->product_name;
        $description = $this->meta_description
            ?: $this->short_description
            ?: $this->warehouseProduct?->short_description;
        $image = $this->warehouseProduct?->main_product_image
            ? asset($this->warehouseProduct->main_product_image)
            : asset('frontend-assets/images/placeholder-product.png');

        return seo()
            ->title($title, config('app.name'))
            ->description($description)
            ->keywords(...array_filter(array_map('trim', explode(',', (string) $this->meta_keywords))))
            ->canonical(route('ecommerce.product.detail', $this->id))
            ->images($image);
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

    public function dealItems()
    {
        return $this->hasMany(ProductDealItem::class);
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}

