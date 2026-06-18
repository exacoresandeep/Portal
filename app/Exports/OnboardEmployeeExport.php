<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OnboardEmployeeExport implements FromCollection, WithHeadings
{
    protected $status;
    protected $job_type;
    protected $department_id;
    protected $designation_id;
    protected $onboard_status;

    public function __construct(
        $status = null,
        $job_type = null,
        $department_id = null,
        $designation_id = null,
        $onboard_status = null
    ) {

        $this->status = $status;

        $this->job_type = $job_type;

        $this->department_id = $department_id;

        $this->designation_id = $designation_id;

        $this->onboard_status = $onboard_status;
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

                $query->where('department_id', $this->department_id);

            })

            ->when($this->designation_id != '', function ($query) {

                $query->where('designation_id', $this->designation_id);

            })

            ->when($this->onboard_status != '', function ($query) {

                $query->where('onboard_status', $this->onboard_status);

            })
            ->where("onboard_status","!=","Completed")
            ->get()

            ->map(function ($employee) {

                return [

                    'Employee ID' => $employee->emp_id,

                    'Employee Name' => $employee->name,

                    'Status' => $employee->status == 1
                        ? 'Active'
                        : 'Inactive',

                    'Job Type' => $employee->job_type,

                    'Department' => $employee->department->name ?? '-',

                    'Designation' => $employee->designation->name ?? '-',

                    'Reporting Manager' => $employee->reportingManager->name ?? '-',

                    'Contact No' => $employee->contact_no,

                    'Emergency Contact' => $employee->alt_contact_no,

                    'Onboard Status' => $employee->onboard_status,

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

            'Contact No',

            'Emergency Contact',

            'Onboard Status'

        ];
    }
}