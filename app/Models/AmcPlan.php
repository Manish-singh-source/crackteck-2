<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AmcPlan extends Model
{
    use SoftDeletes;

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

    protected $casts = [
        'covered_items' => 'array',
    ];

    public function coveredItems()
    {
        return CoveredItem::whereIn('id', $this->covered_items ?? []);
    }
}
