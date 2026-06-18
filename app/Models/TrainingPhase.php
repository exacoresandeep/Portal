<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingPhase extends Model
{
    protected $fillable = [
        'department_id',
        'phase_name',
        'focus',
        'topics',
        'status'
    ];

    protected $casts = [
        'topics' => 'array'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}