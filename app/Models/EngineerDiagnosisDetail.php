<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EngineerDiagnosisDetail extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'service_request_id',
        'service_request_product_id',
        'assigned_engineer_id',
        'covered_item_id',
        'diagnosis_list',
        'diagnosis_photos',
        'diagnosis_videos',
        'diagnosis_notes',
        'diagnosis_report',
        'after_photos',
        'before_photos',
        'completed_at',
    ];

    /**
     * Get the engineer that is assigned to this diagnosis.
     */
    public function engineer()
    {
        return $this->belongsTo(Staff::class, 'assigned_engineer_id');
    }
    
    public function assignedEngineer()
    {
        return $this->belongsTo(AssignedEngineer::class, 'assigned_engineer_id');
    }

    public function coveredItem()
    {
        return $this->belongsTo(CoveredItem::class, 'covered_item_id');
    }
}
