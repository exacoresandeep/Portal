<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employee;
use App\Models\LeaveCount;
use Carbon\Carbon;

class GenerateYearlyLeaveCount extends Command
{
    protected $signature = 'leavecount:generate';

    protected $description = 'Generate yearly leave count for all active employees';

    public function handle()
    {
        $year = now()->year;

        $employees = Employee::where('status', 1)->get();

        foreach ($employees as $employee) {

            // Skip if already created
            $exists = LeaveCount::where('employee_id', $employee->id)
                ->where('year', $year)
                ->exists();

            if ($exists) {
                continue;
            }

            $earnedLeaves = 0;

            if (!empty($employee->confirm_date)) {

                $confirmDate = Carbon::parse($employee->confirm_date);

                if ($confirmDate->lte(now()->subYear())) {
                    $earnedLeaves = 12;
                }
            }

            LeaveCount::create([
                'employee_id'    => $employee->id,
                'year'           => $year,
                'sick_leaves'    => 12,
                'casual_leaves'  => 12,
                'earned_leaves'  => $earnedLeaves,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        $this->info('Leave counts generated successfully.');
    }
}