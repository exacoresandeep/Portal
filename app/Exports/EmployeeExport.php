<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExport implements FromCollection, WithHeadings
{
    protected $status;
    protected $job_type;
    protected $department_id;
    protected $designation_id;

    public function __construct(
        $status,
        $job_type,
        $department_id,
        $designation_id
    ) {
        $this->status = $status;
        $this->job_type = $job_type;
        $this->department_id = $department_id;
        $this->designation_id = $designation_id;
    }

    public function collection()
    {
        return Employee::with([
                'designation',
                'department',
                'reportingManager'
            ])

            ->when($this->status != '', function ($query) {

                $query->where('status', $this->status);

            })

            ->when($this->job_type != '', function ($query) {

                $query->where('job_type', $this->job_type);

            })

            ->when($this->department_id != '', function ($query) {

                $query->where(
                    'department_id',
                    $this->department_id
                );

            })

            ->when($this->designation_id != '', function ($query) {

                $query->where(
                    'designation_id',
                    $this->designation_id
                );

            })
            ->where("onboard_status","Completed")
            ->get()

            ->map(function ($employee) {

                return [

                    'Employee ID' => $employee->emp_id,

                    'Employee Name' => $employee->name,

                    'Status' => $employee->status
                        ? 'Active'
                        : 'Inactive',

                    'Job Type' => $employee->job_type,

                    'Department' => $employee->department->name ?? '-',

                    'Designation' => $employee->designation->name ?? '-',

                    'Reporting Manager' =>
                        $employee->reportingManager->name ?? '-',

                    'Contact' => $employee->contact_no,

                    'Emergency Contact' =>
                        $employee->alt_contact_no,

                ];

            });
    }

    public function headings(): array
    {
        return [

            'Employee ID',

            'Employee Name',

            'Status',

            'Job Type',

            'Department',

            'Designation',

            'Reporting Manager',

            'Contact',

            'Emergency Contact'

        ];
    }
}