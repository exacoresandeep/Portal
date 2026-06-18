<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetRequest extends Model
{
    protected $fillable = [
        'department_id',
        'joining_date',
        'laptop_count',
        'request_status',
        'status'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}