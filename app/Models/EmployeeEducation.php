<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeEducation extends Model
{
    protected $table = 'employee_education';

    protected $fillable = [
        'employee_id',
        'qualification',
        'university_board',
        'passing_year',
        'percentage',
        'attachment',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}