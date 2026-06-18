<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationForm extends Model
{
    protected $fillable = [
        'name',
        'status'
    ];

    public function questions()
    {
        return $this->hasMany(
            EvaluationQuestion::class,
            'evaluation_form_id'
        );
    }
    
    public function getTotalScoreAttribute()
    {
        return $this->questions()->sum('marks');
    }

    public function schedules()
    {
        return $this->hasMany(
            EvaluationSchedule::class,
            'evaluation_form_id'
        );
    }

    public function assignments()
    {
        return $this->hasMany(
            EvaluationAssign::class,
            'evaluation_form_id'
        );
    }
}