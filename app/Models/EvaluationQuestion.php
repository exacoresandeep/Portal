<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationQuestion extends Model
{
    protected $fillable = [
        'evaluation_form_id',
        'question',
        'marks',
        'subpoints',
        'status'
    ];

    protected $casts = [
        'subpoints' => 'array',
    ];

    
    public function form()
    {
        return $this->belongsTo(
            EvaluationForm::class,
            'evaluation_form_id'
        );
    }
}