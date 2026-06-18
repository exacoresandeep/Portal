<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationAssign extends Model
{
    protected $table = 'evaluation_assign';

    protected $fillable = [
        'evaluation_form_id',
        'employee_id',
        'year',
        'quarter',
        'submitted_date',
        'marks',
        'review',
        'reviewed_at',
        'status'
    ];

    protected $casts = [
        'marks' => 'array',
        'assessment_marks' => 'array',
        'justifications' => 'array',
        'submitted_date' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function form()
    {
        return $this->belongsTo(
            EvaluationForm::class,
            'evaluation_form_id'
        );
    }

    public function employee()
    {
        return $this->belongsTo(
            Employee::class,
            'employee_id'
        );
    }
}