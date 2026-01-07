<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignedEngineerGroup extends Model
{
    protected $table = 'assigned_engineer_group';

    protected $fillable = [
        'assignment_id',
        'engineer_id',
        'is_supervisor',
    ];

    protected $casts = [
        'is_supervisor' => 'boolean',
    ];

    public function assignment()
    {
        return $this->belongsTo(AssignedEngineer::class, 'assignment_id');
    }

    public function engineer()
    {
        return $this->belongsTo(Staff::class, 'engineer_id');
    }
}
