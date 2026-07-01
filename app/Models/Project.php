<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_name',
        'project_manager_id',
        'team_head_id',
        'estimated_hours',
        'project_modules',
        'start_date',
        'end_date',
        'status',
        'description',
        'team_members',
        'last_module_index'
    ];
    
    protected $casts = [
        'team_members' => 'array',
        'project_modules' => 'array',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public function getMembersCountAttribute()
    {
        return count($this->team_members ?? []);
    }
    public function projectEmployees()
    {
        return Employee::whereIn(
            'id',
            $this->team_members ?? []
        );
    }
    public function projectManager()
    {
        return $this->belongsTo(
            Employee::class,
            'project_manager_id'
        );
    }

    public function teamHead()
    {
        return $this->belongsTo(
            Employee::class,
            'team_head_id'
        );
    }
}