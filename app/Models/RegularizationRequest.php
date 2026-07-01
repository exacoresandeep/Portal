<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegularizationRequest extends Model
{
    protected $fillable = [
        'employee_id',
        'date',
        'direction',
        'reason',
        'action_date',
        'status',
        'action_by'
    ];

    protected $casts = [
        'date' => 'date',
        'action_date' => 'datetime'
    ];

    public function employee()
    {
        return $this->belongsTo(
            Employee::class,
            'employee_id'
        );
    }

    public function actionBy()
    {
        return $this->belongsTo(
            User::class,
            'action_by'
        );
    }
}