<?php

namespace App\Exports;

use App\Models\Leave;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WfhRequestExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Leave::with(['employee.designation'])
            ->where('leave_type', 'WFH');

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

        if (!empty($this->request['filter_designation'])) {
            $query->whereHas('employee', function ($q) {
                $q->where(
                    'designation_id',
                    $this->request['filter_designation']
                );
            });
        }

        return $query->get()->map(function ($row) {

            return [
                'Employee Name' => $row->employee?->name ?? '-',
                'Employee ID' => $row->employee?->emp_id ?? '-',
                'Designation' => $row->employee?->designation?->name ?? '-',
                'From Date' => Carbon::parse($row->from_date)->format('d-m-Y'),
                'To Date' => Carbon::parse($row->to_date)->format('d-m-Y'),
                'Reason' => $row->reason,
                'Requested Date' => Carbon::parse($row->created_at)->format('d-m-Y'),
                'Manager Status' => $row->manager_status,
                'Status' => $row->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Employee ID',
            'Designation',
            'From Date',
            'To Date',
            'Reason',
            'Requested Date',
            'Manager Status',
            'Status'
        ];
    }
}