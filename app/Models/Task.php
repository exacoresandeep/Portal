<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'task_code',
        'project_id',
        'module_id',
        'task_name'
    ];

    
    public function latestUpdate()
    {
        return $this->hasOne(TaskUpdate::class)
            ->latestOfMany();
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(Employee::class,'assigned_to');
    }

    public function assignedBy()
    {
        return $this->belongsTo(Employee::class,'assigned_by');
    }

    public function updates()
    {
        return $this->hasMany(TaskUpdate::class);
    }
}