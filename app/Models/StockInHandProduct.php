<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockInHandProduct extends Model
{
    //
    protected $fillable = [
        'stock_in_hand_id',
        'product_id',
        'product_serial_id',
        'requested_quantity',
        'delivered_quantity',
        'unit_price',
        'status',
        'notes',
        'picked_at',
        'returned_at',
    ];
}
