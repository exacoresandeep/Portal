<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Department;
use App\Models\Designation;
use App\Models\JobType;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $departmentIds = Department::pluck('id')->toArray();

        $designationIds = Designation::pluck('id')->toArray();

        $jobTypes = JobType::pluck('type')->toArray();

        $onboardStatuses = [

            'Pending',

            'Profile Created',

            'Completed'

        ];

        for ($i = 1; $i <= 25; $i++) {

            DB::table('employees')->insert([

                'emp_id' => 'E' . str_pad($i, 4, '0', STR_PAD_LEFT),

                'name' => 'Employee ' . $i,

                'email' => 'employee'.$i.'@mail.com',

                'password' => Hash::make('password'),

                'dob' => now()
                    ->subYears(rand(22, 35))
                    ->format('Y-m-d'),

                'job_type' => $jobTypes[array_rand($jobTypes)],

                'department_id' => $departmentIds[array_rand($departmentIds)],

                'designation_id' => $designationIds[array_rand($designationIds)],

                'reporting_manager_id' => rand(1, 5),

                'onboard_status' => $onboardStatuses[array_rand($onboardStatuses)],

                'contact_no' => '9876543' . rand(100, 999),

                'alt_contact_no' => '9898989' . rand(100, 999),

                

                'pan_no' => 'ABCDE'.rand(1000,9999).'F',

                'aadhar_no' => rand(
                    100000000000,
                    999999999999
                ),

                'status' => rand(0,1),

                'data_status' => 1,

                'created_at' => now(),

                'updated_at' => now(),

            ]);
        }
    }
}