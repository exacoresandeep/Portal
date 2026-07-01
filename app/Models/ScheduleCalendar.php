<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleCalendar extends Model
{
    protected $fillable = [
        'year',
        'project_id',
        'holidays'
    ];

    protected $casts = [
        'holidays' => 'array'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}