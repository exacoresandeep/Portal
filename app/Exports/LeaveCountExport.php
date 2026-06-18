<?php

namespace App\Exports;

use App\Models\Leave;
use App\Models\LeaveCount;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeaveCountExport implements FromCollection, WithHeadings
{
    protected $year;
    protected $departmentId;

    public function __construct($year, $departmentId = null)
    {
        $this->year = $year;
        $this->departmentId = $departmentId;
    }

    public function collection()
    {
        $query = LeaveCount::with(['employee.department'])
            ->where('year', $this->year);

        if ($this->departmentId) {
            $query->whereHas('employee', function ($q) {
                $q->where('department_id', $this->departmentId);
            });
        }

        return $query->get()->map(function ($row) {

            $totalLeave = $row->sick_leaves +
                          $row->casual_leaves +
                          $row->earned_leaves;

            $usedLeave = Leave::where('employee_id', $row->employee_id)
                ->whereYear('from_date', $row->year)
                ->where('status', 'Approved')
                ->count();

            return [
                'Employee Name' => $row->employee?->name,
                'Employee ID' => $row->employee?->emp_id,
                'Department' => $row->employee?->department?->name,
                'Year' => $row->year,
                'Total Leave' => $totalLeave,
                'Used Leave' => $usedLeave,
                'Balance Leave' => $totalLeave - $usedLeave,
                'Sick Leave' => $row->sick_leaves,
                'Casual Leave' => $row->casual_leaves,
                'Earned Leave' => $row->earned_leaves,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Employee ID',
            'Department',
            'Year',
            'Total Leave',
            'Used Leave',
            'Balance Leave',
            'Sick Leave',
            'Casual Leave',
            'Earned Leave',
        ];
    }
}