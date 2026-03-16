<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class AmcProduct extends Model
{
    //
    use LogsActivity;

    protected $fillable = [
        'amc_id',
        'name',
        'type',
        'model_no',
        'mac_address',
        'sku',
        'hsn',
        'purchase_date',
        'brand',
        'images',
        'description',
        'status',
        'created_at',
        'updated_at',
    ];


    /**
     * Configure activity logging options.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'amc_id',
                'name',
                'type',
                'model_no',
                'mac_address',
                'sku',
                'hsn',
                'purchase_date',
                'brand',
                'images',
                'description',
                'status',
                'created_at',
                'updated_at',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "AMC {$eventName}");
    }

    protected $casts = [
        'images' => 'array',
    ];

    public function amc()
    {
        return $this->belongsTo(Amc::class, 'amc_id');
    }

    public function productType() {
        return $this->belongsTo(DeviceSpecificDiagnosis::class, 'type');
    }
}
