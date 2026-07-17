<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PayrollTemplateExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Employee::where('status', 1)
            ->select(
                'emp_id as employee_id',
                'name as employee_name',
                'ifsc',
                'account_no',
                'bank_name'
            )
            ->get()
            ->map(function ($employee) {

                return [

                    $employee->employee_id,
                    $employee->employee_name,

                    '', // Team
                    '', // Billing Unit
                    '', // Gender
                    '', // Net Payment
                    '', // Basic
                    '', // Other Allowance
                    '', // Performance Bonus
                    '', // Project Allowance
                    '', // Special Allowance
                    '', // Total Earnings
                    '', // Professional Tax
                    '', // PF
                    '', // Income Tax
                    '', // LWF
                    '', // Salary Deductions
                    '', // ESI
                    '', // Total Deduction
                    '', // Net Salary
                    '', // Days In Month
                    '', // Present Days
                    '', // Daily Rate
                    '', // Advance
                    '', // Recovery
                    '', // Balance
                    '', // Project Bonus Days
                    '', // Project Days Available
                    '', // WFH
                    '', // Per Day Deduction
                    '', // Total Deduction 2
                    $employee->ifsc, // IFSC Code
                    $employee->account_no, // Bank Account Number
                    $employee->bank_name, // Bank

                ];
            });
    }

    public function headings(): array
    {
        return [

            'Employee ID',
            'Employee Name',
            'Team',
            'Billing Unit',
            'Gender',
            'Net Payment',
            'Basic',
            'House Rent Allowance',
            'Conveyance Allowance',
            'Medical Allowance',
            'Telephone Allowance',
            'CEA',
            'Other Allowance',
            'Performance Bonus',
            'Project Allowance',
            'Special Allowance',
            'Total Earnings',
            'Professional Tax',
            'PF',
            'Income Tax',
            'LWF',
            'Salary Deductions',
            'ESI',
            'Total Deduction',
            'Net Salary',
            'Days In Month',
            'Present Days',
            'Daily Rate',
            'Advance',
            'Recovery',
            'Balance',
            'Project Bonus Days',
            'Project Days Available',
            'WFH',
            'Per Day Deduction',
            'Total Deduction 2',
            'IFSC Code',
            'Bank Account Number',
            'Bank',

        ];
    }
}