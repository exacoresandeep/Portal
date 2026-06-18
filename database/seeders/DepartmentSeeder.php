<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [

            'HR',
            'Admin',
            'Technical',
            'Finance',
            'SCM',
            'Management',
            'Digital',
            'Sales',
            'Marketing',
            'Accounts'

        ];

        foreach ($departments as $department) {

            Department::create([

                'name' => $department,

                'status' => 'active'

            ]);

        }
    }
}