<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AmcTicket extends Model
{
    protected $fillable = [
        'ticket_no',
        'customer_id',
        'amc_id',
        'service_id',
        'subject',
        'description',
        'priority',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function amc()
    {
        return $this->belongsTo(Amc::class, 'amc_id');
    }

    /**
     * Generate a unique ticket number
     */
    public static function generateTicketNo()
    {
        $lastTicket = self::orderBy('id', 'desc')->first();
        $lastId = $lastTicket ? $lastTicket->id : 0;

        return 'AMC-TICKET-'.str_pad($lastId + 1, 5, '0', STR_PAD_LEFT);
    }
}
