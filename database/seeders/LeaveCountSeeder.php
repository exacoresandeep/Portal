<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaveCountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $year = 2026;

        $employees = Employee::all();

        foreach ($employees as $employee) {

            DB::table('leave_counts')->updateOrInsert(
                [
                    'employee_id' => $employee->id,
                    'year' => $year,
                ],
                [
                    'casual_leaves' => 12,
                    'sick_leaves' => 12,
                    'earned_leaves' => rand(0, 12),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}