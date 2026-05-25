<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;


class Employee extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'dob',
        'designation',
        'contact_no',
        'alt_contact_no',
        'type',
        'pan_no',
        'aadhar_no',
        'status',
        'data_status'
    ];

    protected $hidden = [
        'password',
    ];
}