<?php

namespace App\Exports;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceTrackingExport implements
    FromArray,
    WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {
        return [
            'Date',
            'Employee ID',
            'Employee Name',
            'Department',
            'Check In',
            'Check Out',
            'Hours',
            'Status'
        ];
    }

    public function array(): array
    {
        $request = $this->request;

        $fromDate = Carbon::parse($request->from_date);
        $toDate   = Carbon::parse($request->to_date);

        $employees = Employee::with('department')
            ->where('status', 1)
            ->when(
                $request->department_id,
                fn ($q) =>
                    $q->where(
                        'department_id',
                        $request->department_id
                    )
            )
            ->get();

        $rows = [];

        while ($fromDate->lte($toDate)) {

            $tableName =
                'z_attendance_log_' .
                $fromDate->month .
                '_' .
                $fromDate->year;

            foreach ($employees as $employee) {

                $firstIn = null;
                $lastOut = null;
                $workSeconds = 0;

                if (Schema::hasTable($tableName)) {

                    $logs = DB::table($tableName)
                        ->where(
                            'employee_id',
                            $employee->id
                        )
                        ->whereDate(
                            'log_date',
                            $fromDate->toDateString()
                        )
                        ->orderBy('log_date')
                        ->get();

                    $inTime = null;

                    foreach ($logs as $log) {

                        if (
                            !$firstIn &&
                            $log->direction == 'in'
                        ) {
                            $firstIn = $log->log_date;
                        }

                        if ($log->direction == 'in') {

                            $inTime = Carbon::parse(
                                $log->log_date
                            );

                        } elseif (
                            $log->direction == 'out' &&
                            $inTime
                        ) {

                            $outTime = Carbon::parse(
                                $log->log_date
                            );

                            $workSeconds +=
                                $inTime->diffInSeconds(
                                    $outTime
                                );

                            $lastOut = $log->log_date;

                            $inTime = null;
                        }
                    }
                }

                $hours = floor($workSeconds / 3600);
                $minutes = floor(($workSeconds % 3600) / 60);
                $seconds = $workSeconds % 60;

                $workingHours = sprintf(
                    '%02d:%02d:%02d',
                    $hours,
                    $minutes,
                    $seconds
                );

                if ($workSeconds == 0) {

                    $status = 'Absent';

                } elseif ($workSeconds < 14400) {

                    $status = 'Half Day';

                } else {

                    $status = 'Present';
                }

                if (
                    $request->status &&
                    $status != $request->status
                ) {
                    continue;
                }

                $rows[] = [
                    $fromDate->format('d-m-Y'),
                    $employee->emp_id,
                    $employee->name,
                    optional(
                        $employee->department
                    )->name,
                    $firstIn
                        ? Carbon::parse($firstIn)
                            ->format('h:i A')
                        : '-',
                    $lastOut
                        ? Carbon::parse($lastOut)
                            ->format('h:i A')
                        : '-',
                    $workingHours,
                    $status
                ];
            }

            $fromDate->addDay();
        }

        return $rows;
    }
}