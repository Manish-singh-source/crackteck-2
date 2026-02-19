<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AmcProduct extends Model
{
    //
    protected $fillable = [
        'amc_id',
        'name',
        'type',
        'model_no',
        'sku',
        'hsn',
        'purchase_date',
        'brand',
        'images',
        'description',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function amc()
    {
        return $this->belongsTo(Amc::class, 'amc_id');
    }
}
