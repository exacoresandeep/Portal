<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveCount extends Model
{
    use HasFactory;

    protected $table = 'leave_counts';

    protected $fillable = [
        'employee_id',
        'year',
        'sick_leaves',
        'casual_leaves',
        'earned_leaves',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}