<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseRack extends Model
{
    //
    protected $fillable = [
        'warehouse_id',
        'rack_name',
        'zone_area',
        'rack_no',
        'level_no',
        'position_no',
        'floor',
        'quantity',
        'filled_quantity',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
