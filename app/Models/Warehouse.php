<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warehouse extends Model
{
    //
    protected $fillable = [
        'name',
        'type',
        'address1',
        'address2',
        'city',
        'state',
        'country',
        'pincode',
        'contact_person_name',
        'phone_number',
        'alternate_phone_number',
        'email',
        'working_hours',
        'working_days',
        'max_store_capacity',
        'supported_operations',
        'zone_conf',
        'gst_no',
        'licence_no',
        'licence_doc',
        'verification_status',
        'default_warehouse',
        'status',
    ];

    public function racks(): HasMany
    {
        return $this->hasMany(WarehouseRack::class, 'warehouse_id');
    }
}
