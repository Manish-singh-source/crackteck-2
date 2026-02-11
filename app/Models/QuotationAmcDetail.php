<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationAmcDetail extends Model
{
    //
    protected $fillable = [
        'quotation_id',
        'amc_plan_id',
        'plan_duration',
        'plan_start_date',
        'plan_end_date',
        'total_amount',
        'priority_level',
        'additional_notes',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function amcPlan()
    {
        return $this->belongsTo(AmcPlan::class);
    }

    
}
