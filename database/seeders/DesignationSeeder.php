<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Designation;

class DesignationSeeder extends Seeder
{
    public function run(): void
    {
        $designations = [

            'Tester',

            'PHP Developer',

            'UI/UX Designer',

            'HR Manager',

            'Team Lead',

            'Project Manager',

        ];

        foreach ($designations as $designation) {

            Designation::updateOrCreate(
                ['name' => $designation],
                ['status' => 'active']
            );

        }
    }
}