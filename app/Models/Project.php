<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'project_name',
        'start_date',
        'end_date',
        'team_members',
        'status',
        'description'
    ];

    protected $casts = [
        'team_members' => 'array',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public function getMembersCountAttribute()
    {
        return count($this->team_members ?? []);
    }
}