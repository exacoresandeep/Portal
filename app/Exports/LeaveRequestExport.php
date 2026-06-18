<?php

namespace App\Exports;

use App\Models\Leave;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeaveRequestExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Leave::with('employee');

        if (!empty($this->request['from_date'])) {
            $query->whereDate('from_date', '>=', $this->request['from_date']);
        }

        if (!empty($this->request['to_date'])) {
            $query->whereDate('to_date', '<=', $this->request['to_date']);
        }

        if (!empty($this->request['status'])) {
            $query->where('status', $this->request['status']);
        }

        if (!empty($this->request['manager_status'])) {
            $query->where('manager_status', $this->request['manager_status']);
        }

        if (!empty($this->request['leave_type'])) {
            $query->where('leave_type', $this->request['leave_type']);
        }

        $query->where('leave_type', '!=', 'WFH');

        return $query->get()->map(function ($row) {

            return [
                'Employee Name' => $row->employee->name ?? '-',
                'Employee ID' => $row->employee->emp_id ?? '-',
                'From Date' => Carbon::parse($row->from_date)->format('d-m-Y'),
                'To Date' => Carbon::parse($row->to_date)->format('d-m-Y'),
                'Leave Count' => Carbon::parse($row->from_date)
                    ->diffInDays(Carbon::parse($row->to_date)) + 1,
                'Applied Date' => Carbon::parse($row->created_at)->format('d-m-Y'),
                'Leave Type' => $row->leave_type,
                'Manager Status' => $row->manager_status,
                'Status' => $row->status,
                'Reason' => $row->reason,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Employee ID',
            'From Date',
            'To Date',
            'Leave Count',
            'Applied Date',
            'Leave Type',
            'Manager Status',
            'Status',
            'Reason'
        ];
    }
}