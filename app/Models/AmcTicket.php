<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class AmcTicket extends Model
{
    use LogsActivity;

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


    /**
     * Configure activity logging options.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'ticket_no',
                'customer_id',
                'amc_id',
                'service_id',
                'subject',
                'description',
                'priority',
                'status',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "AMC {$eventName}");
    }


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

        return 'AMC-TICKET-' . str_pad($lastId + 1, 5, '0', STR_PAD_LEFT);
    }
}
