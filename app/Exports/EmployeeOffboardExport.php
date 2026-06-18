<?php

namespace App\Exports;

use App\Models\EmployeeOffboard;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeOffboardExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $employees = EmployeeOffboard::with([
            'employee',
            'employee.designation',
            'employee.reportingManager'
        ])

        ->when($this->request->hr_process != '', function ($query) {

            $query->where('hr_process', $this->request->hr_process);

        })

        ->when($this->request->emp_process != '', function ($query) {

            $query->where('emp_process', $this->request->emp_process);

        })

        ->when($this->request->job_type != '', function ($query) {

            $query->whereHas('employee', function ($q) {

                $q->where('job_type', $this->request->job_type);

            });

        })

        ->when($this->request->department_id != '', function ($query) {

            $query->whereHas('employee', function ($q) {

                $q->where('department_id', $this->request->department_id);

            });

        })

        ->when($this->request->designation_id != '', function ($query) {

            $query->whereHas('employee', function ($q) {

                $q->where('designation_id', $this->request->designation_id);

            });

        })

        ->get();

        return $employees->map(function ($row, $index) {

            return [

                'Sl No' => $index + 1,

                'Employee Name' =>
                    $row->employee->name ?? '-',

                'Employee ID' =>
                    $row->employee->emp_id ?? '-',

                'Job Type' =>
                    $row->employee->job_type ?? '-',

                'Designation' =>
                    $row->employee->designation->name ?? '-',

                'Reporting Manager' =>
                    $row->employee->reportingManager->name ?? '-',

                'Joining Date' =>
                    $row->employee->joining_date
                        ? date('d-m-Y', strtotime($row->employee->joining_date))
                        : '-',

                'Leaving Date' =>
                    $row->leaving_date
                        ? date('d-m-Y', strtotime($row->leaving_date))
                        : '-',

                'Submission Status' =>
                    ucfirst($row->emp_process),

                'HR Process Status' =>
                    ucfirst($row->hr_process),

            ];

        });
    }

    public function headings(): array
    {
        return [
            'Sl No.',
            'Employee Name',
            'Employee ID',
            'Job Type',
            'Designation',
            'Reporting Manager',
            'Joining Date',
            'Leaving Date',
            'Submission Status',
            'HR Process Status'
        ];
    }
}