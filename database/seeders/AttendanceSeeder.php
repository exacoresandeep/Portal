<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $records = [];

        // First 10 employees
        for ($employeeId = 1; $employeeId <= 10; $employeeId++) {

            // 2 or 3 IN/OUT sessions per employee
            $sessions = rand(2, 3);

            $time = Carbon::today()->addHours(8);

            for ($i = 1; $i <= $sessions; $i++) {

                // Punch In
                $inTime = $time->copy()->addMinutes(rand(0, 30));

                $records[] = [
                    'employee_id' => $employeeId,
                    'direction'   => 'in',
                    'created_at'  => $inTime,
                    'updated_at'  => $inTime,
                ];

                // Punch Out
                $outTime = $inTime->copy()->addHours(rand(1, 4));

                $records[] = [
                    'employee_id' => $employeeId,
                    'direction'   => 'out',
                    'created_at'  => $outTime,
                    'updated_at'  => $outTime,
                ];

                // Next session starts later
                $time = $outTime->copy()->addMinutes(rand(30, 90));
            }
        }

        shuffle($records);

        // Keep only 50 records
        Attendance::insert(array_slice($records, 0, 50));
    }
}