<?php

namespace App\Exports;

use App\Models\EvaluationAssign;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EvaluationReportExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = EvaluationAssign::with([
            'employee.department',
            'form' => function ($q) {
                $q->withSum('questions', 'marks');
            }
        ]);

        if ($this->request->year) {
            $query->where('year', $this->request->year);
        }

        if ($this->request->quater) {
            $query->where('quarter', $this->request->quater);
        }

        if ($this->request->department_id) {

            $query->whereHas('employee', function ($q) {

                $q->where(
                    'department_id',
                    $this->request->department_id
                );

            });
        }

        if ($this->request->performance_status) {

            $query->where(
                'review',
                $this->request->performance_status
            );
        }

        if ($this->request->submission_status) {

            $this->request->submission_status == 'completed'
                ? $query->whereNotNull('submitted_date')
                : $query->whereNull('submitted_date');
        }

        return $query->get()->map(function ($row) {

            $obtainedMarks = $row->marks
                ? array_sum($row->marks)
                : 0;

            $totalMarks = $row->form->questions_sum_marks ?? 0;

            return [

                'Employee Name' =>
                    $row->employee->name ?? '',

                'Employee ID' =>
                    $row->employee->emp_id ?? '',

                'Form Name' =>
                    $row->form->name ?? '',

                'Department' =>
                    $row->employee->department->name ?? '',

                'Year' =>
                    $row->year,

                'Quarter' =>
                    $row->quarter,

                'Submitted Date' =>
                    $row->submitted_date
                        ? date(
                            'd-m-Y',
                            strtotime($row->submitted_date)
                        )
                        : '',

                'Assessment Score' =>
                    $obtainedMarks.'/'.$totalMarks,

                'Performance Review' =>
                    $row->review,

                'Submission Status' =>
                    $row->submitted_date
                        ? 'Completed'
                        : 'Pending',

            ];

        });
    }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Employee ID',
            'Form Name',
            'Department',
            'Year',
            'Quarter',
            'Submitted Date',
            'Assessment Score',
            'Performance Review',
            'Submission Status'
        ];
    }
}
