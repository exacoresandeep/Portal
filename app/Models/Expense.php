<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'employee_id',
        'amount',
        'purpose',
        'document',
        'status',
        'action_at'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}