<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskUpdate extends Model
{
    protected $fillable = [
        'task_id',
        'task_name',
        'employee_id',
        'assigned_by',
        'priority',
        'start_date',
        'end_date',
        'status',
        'progress',
        'hours_worked',
        'remaining_hours',
        'dependencies',
        'work_summary',
        'attachment',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
    public function employee()
    {
        return $this->belongsTo(
            Employee::class,
            'employee_id'
        );
    }
    public function assignedBy()
    {
        return $this->belongsTo(
            Employee::class,
            'assigned_by'
        );
    }
}