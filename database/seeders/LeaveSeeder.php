<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Leave;
use Carbon\Carbon;

class LeaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leaveTypes = [
            'Sick',
            'Casual',
            'Earned',
            'WFH',
            'Maternity',
            'LOP'
        ];

        $statuses = [
            'Pending',
            'Approved',
            'Rejected'
        ];

        for ($i = 1; $i <= 50; $i++) {

            $fromDate = Carbon::now()->subDays(rand(1, 60));
            $toDate = (clone $fromDate)->addDays(rand(0, 3));

            $status = $statuses[array_rand($statuses)];

            Leave::create([
                'employee_id' => rand(1, 10),

                'from_date' => $fromDate->format('Y-m-d'),
                'to_date' => $toDate->format('Y-m-d'),

                'leave_type' => $leaveTypes[array_rand($leaveTypes)],

                'reason' => collect([
                    'Personal Work',
                    'Family Function',
                    'Medical Emergency',
                    'Vacation',
                    'Personal Reason',
                    'Bank Work',
                    'Wedding Function'
                ])->random(),

                'attachment' => null,

                'status' => $status,

                'action_date' => $status != 'Pending'
                    ? Carbon::parse($toDate)->addDay()
                    : null,

                'action_by' => $status != 'Pending'
                    ? rand(1, 3)
                    : null,

                'created_at' => $fromDate->copy()->subDays(rand(1, 5)),
                'updated_at' => now(),
            ]);
        }
    }
}