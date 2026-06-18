<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobType;
use App\Models\Department;
use App\Models\Designation;
class AttendanceController extends Controller
{
    
    public function capture()
    {
        $jobTypes = JobType::where('status', 'active')->get();
        $departments = Department::where('status', 'active')->get();
        $designations = Designation::where('status', 'active')->get();

        return view('pages.attendance.capture',compact(
                    'jobTypes',
                    'departments',
                    'designations'
                ));
    }
    

    public function schedule()
    {
        return view('pages.attendance.schedule');
    }

    public function tracking()
    {
        return view('pages.attendance.tracking');
    }

    public function regularization()
    {
        return view('pages.attendance.regularization');
    }

    public function summary()
    {
        return view('pages.attendance.summary');
    }

    public function reports()
    {
        return view('pages.attendance.reports');
    }
} 
