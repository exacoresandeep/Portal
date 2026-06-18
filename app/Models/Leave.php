<?php

namespace App\Models;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $table = 'leaves';

    protected $fillable = [
        'employee_id',
        'from_date',
        'to_date',
        'leave_type',
        'reason',
        'attachment',
        'status',
        'action_date',
        'action_by',
    ];

    protected $casts = [
        'from_date' => 'date',
        'to_date' => 'date',
        'action_date' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function approver()
    {
        return $this->belongsTo(Employee::class, 'action_by');
    }
}