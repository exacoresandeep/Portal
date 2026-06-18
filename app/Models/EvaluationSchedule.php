<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationSchedule extends Model
{
    protected $table = 'evaluation_schedule';

    protected $fillable = [
        'evaluation_form_id',
        'department_id',
        'year',
        'quarter',
        'end_date'
    ];

    protected $casts = [
        'end_date' => 'date',
    ];

    public function form()
    {
        return $this->belongsTo(
            EvaluationForm::class,
            'evaluation_form_id'
        );
    }

    public function department()
    {
        return $this->belongsTo(
            Department::class,
            'department_id'
        );
    }
}