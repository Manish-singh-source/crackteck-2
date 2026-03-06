<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class AmcPlan extends Model
{
    use SoftDeletes, LogsActivity;

    //
    protected $table = 'amc_plans';

    protected $fillable = [
        'plan_name',
        'plan_code',

        'description',
        'duration',
        'total_visits',

        'plan_cost',
        'tax',
        'total_cost',
        'pay_terms',

        'support_type',
        'covered_items',

        'brochure',
        'tandc',
        'replacement_policy',

        'status',
    ];

    /**
     * Configure activity logging options.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'plan_name',
                'plan_code',
                'description',
                'duration',
                'total_visits',
                'plan_cost',
                'tax',
                'total_cost',
                'pay_terms',
                'support_type',
                'covered_items',
                'brochure',
                'tandc',
                'replacement_policy',
                'status',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "AMC {$eventName}");
    }

    protected $casts = [
        'covered_items' => 'array',
    ];

    public function coveredItems()
    {
        return CoveredItem::whereIn('id', $this->covered_items ?? []);
    }
}
