<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    protected $fillable = [
        'emp_id',
        'name',
        'gender',
        'marital_status',
        'blood_group',
        'parent_name',
        'nationality',
        'address',
        'email',
        'personal_email',
        'password',
        'photo',
        'dob',
        'contact_no',
        'alt_contact_no',
        'job_type',
        'employment_type',
        'work_location',
        'job_location',
        'department_id',
        'designation_id',
        'reporting_manager_id',
        'joining_date',
        'confirm_date',
        'onboard_status',
        'pan_no',
        'aadhar_no',
        'passport_no',
        'uan',
        'insurance_no',
        'bank_name',
        'account_no',
        'ifsc',
        'branch',
        'adhar_card',
        'pan_card',
        'resume',
        'passport',
        'passbook',
        'insurance',
        'status',
        'data_status',

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
    
    public function educations()
    {
        return $this->hasMany(EmployeeEducation::class);
    }

    public function evaluationForms()
    {
        return $this->hasMany(EvaluationAssign::class,'employee_id');
    }
    public function experiences()
    {
        return $this->hasMany(EmployeeExperience::class);
    }
}