<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingPhaseAssign extends Model
{
    protected $fillable = [
        'training_phase_id',
        'trainee_id',
        'trainer_id',
        'status',
        'hr_status',
        'hr_remark',
        'assigned_date',
    ];

    protected $casts = [
        'assigned_date' => 'datetime',
    ];

    public function trainingPhase()
    {
        return $this->belongsTo(TrainingPhase::class);
    }

    public function trainee()
    {
        return $this->belongsTo(Employee::class, 'trainee_id');
    }

    public function trainer()
    {
        return $this->belongsTo(Employee::class, 'trainer_id');
    }
}