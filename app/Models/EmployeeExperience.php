<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeExperience extends Model
{
    protected $fillable = [
        'employee_id',
        'company_name',
        'job_role',
        'year_of_experience',
        'attachment'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}