<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
     protected $fillable = [
        'employee_id',
        'laptop_brand',
        'asset_no',
        'vendor',
        'mouse_code',
        'serial_no',
        'ram',
        'sys_config',
        'os_version',
        'transfer_at',
        'status'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }
}
