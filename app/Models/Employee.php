<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    protected $fillable = [

        'emp_id',

        'name',

        'email',

        'password',

        'dob',

        'job_type',

        'department_id',

        'designation_id',

        'reporting_manager_id',

        'onboard_status',

        'contact_no',

        'alt_contact_no',

        'joining_date',
        
        'confirm_date',

        'pan_no',

        'aadhar_no',

        'status',

        'data_status'

    ];

    protected $hidden = [

        'password',

    ];


    public function reportingManager()
    {
        return $this->belongsTo(
            Employee::class,
            'reporting_manager_id'
        );
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
    // public function leaveCounts()
    // {
    //     return $this->hasMany(LeaveCount::class, 'employee_id');
    // }
    public function evaluationForms()
    {
        return $this->hasMany(EvaluationAssign::class,'employee_id');
    }
}