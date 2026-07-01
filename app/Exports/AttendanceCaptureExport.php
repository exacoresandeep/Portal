<?php
namespace App\Exports;

use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceCaptureExport implements FromCollection, WithHeadings
{
    protected $status;

    public function __construct($status = null)
    {
        $this->status = $status;
    }

    public function collection()
    {
        $tableName = 'z_attendance_log_' . now()->format('n_Y');

        $employees = Employee::where('status', 1)->get();

        if ($this->status) {

            $presentEmployeeIds = DB::table($tableName)
                ->whereDate('log_date', today())
                ->pluck('employee_id')
                ->unique()
                ->toArray();

            if ($this->status == 'Present') {
                $employees = $employees->whereIn('id', $presentEmployeeIds);
            }

            if ($this->status == 'Absent') {
                $employees = $employees->whereNotIn('id', $presentEmployeeIds);
            }
        }

        return $employees->map(function ($employee) use ($tableName) {

            $logs = DB::table($tableName)
                ->where('employee_id', $employee->id)
                ->whereDate('log_date', today())
                ->orderBy('log_date')
                ->get();

            // In Time
            $inTime = optional(
                $logs->where('direction', 'in')->first()
            )->log_date;

            // Out Time
            $outTime = optional(
                $logs->where('direction', 'out')->last()
            )->log_date;

            // Work Time
            $totalSeconds = 0;
            $lastIn = null;

            foreach ($logs as $log) {

                if ($log->direction == 'in') {
                    $lastIn = Carbon::parse($log->log_date);
                }

                if ($log->direction == 'out' && $lastIn) {

                    $totalSeconds += $lastIn->diffInSeconds(
                        Carbon::parse($log->log_date)
                    );

                    $lastIn = null;
                }
            }

            if ($lastIn) {
                $totalSeconds += $lastIn->diffInSeconds(now());
            }

            $workTime = gmdate('H:i:s', $totalSeconds);

            $overtimeSeconds = max(0, $totalSeconds - 28800);
            $overtime = gmdate('H:i:s', $overtimeSeconds);

            // Total Time
            $totalTime = '00:00:00';

            if ($logs->count()) {

                $firstIn = $logs->firstWhere('direction', 'in');

                if ($firstIn) {

                    $lastLog = $logs->last();

                    $endTime = $lastLog->direction == 'out'
                        ? Carbon::parse($lastLog->log_date)
                        : now();

                    $seconds = Carbon::parse($firstIn->log_date)
                        ->diffInSeconds($endTime);

                    $totalTime = gmdate('H:i:s', $seconds);
                }
            }

            return [
                'Employee Name' => $employee->name,
                'Employee ID'   => $employee->emp_id,
                'In Time'       => $inTime
                    ? Carbon::parse($inTime)->format('H:i:s')
                    : '-',
                'Out Time'      => $outTime
                    ? Carbon::parse($outTime)->format('H:i:s')
                    : '-',
                'Work Time'     => $workTime,
                'Over Time'     => $overtime,
                'Total Time'    => $totalTime,
                'Status'        => $logs->count() ? 'Present' : 'Absent',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Employee ID',
            'In Time',
            'Out Time',
            'Work Time',
            'Over Time',
            'Total Time',
            'Status'
        ];
    }
}