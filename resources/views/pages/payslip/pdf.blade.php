<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payslip - {{ $payroll->employee_name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #222;
            line-height: 1.4;
            padding: 20px;
        }

        .container {
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td, th {
            padding: 5px 7px;
            vertical-align: top;
        }

        .text-center { text-align: center; }
        .text-end    { text-align: right; }
        .text-left   { text-align: left; }
        .fw-bold     { font-weight: bold; }
        .fw-semibold { font-weight: 600; }
        .small       { font-size: 10px; }

        /* Company Header */
        .company-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .company-address {
            font-size: 10px;
            color: #666;
        }

        .payslip-title {
            display: inline-block;
            border: 1px solid #333;
            padding: 6px 20px;
            font-size: 11px;
            font-weight: 600;
            margin-top: 10px;
        }

        hr {
            border: none;
            border-top: 1px solid #ddd;
            margin: 12px 0;
        }

        /* Employee/Bank Details tables (borderless small tables) */
        .details-table td {
            padding: 3px 5px;
            border: none;
            font-size: 11px;
        }

        .details-table td:first-child {
            width: 40%;
            color: #555;
        }

        /* Earnings / Deductions tables */
        .data-table {
            border: 1px solid #000;
            border-collapse: collapse;
            width: 100%;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #000;
            padding: 6px 8px;
            font-size: 11px;
        }

        .data-table thead th {
            background: #212529;
            color: #fff;
            font-weight: bold;
            text-align: left;
        }

        .data-table thead th.text-end {
            text-align: right;
        }

        .data-table tr.total-row td {
            font-weight: bold;
        }

        /* Net Pay Box */
        .net-pay-box {
            background: #f4630a;
            color: #fff;
            padding: 18px 22px;
            margin-top: 18px;
        }

        .net-pay-box .np-label {
            font-size: 11px;
            opacity: 0.9;
        }

        .net-pay-box .np-amount {
            font-size: 24px;
            font-weight: bold;
            margin-top: 4px;
        }

        .net-pay-box .np-right {
            text-align: right;
            font-size: 10px;
        }

        .footer-note {
            text-align: center;
            margin-top: 18px;
            font-size: 10px;
            color: #777;
        }

        /* Two column outer wrapper (avoids float issues in dompdf) */
        .two-col {
            width: 100%;
            border-collapse: collapse;
        }

        .two-col > tbody > tr > td {
            vertical-align: top;
            padding: 0;
        }

        .col-left  { width: 50%; padding-right: 6px !important; }
        .col-right { width: 50%; padding-left: 6px !important; }
    </style>
</head>
<body>

<div class="container">

    {{-- Company Header --}}
    <div class="text-center">
        <div class="company-name">EXACORE IT SOLUTIONS PVT LTD</div>
        <div class="company-address">
            1st Floor, Indeevaram Bldg, Infopark Smart Space,
            Koratty, Thrissur - 680308
        </div>
        <div class="payslip-title">
            Payslip for the Month of
            {{ date('F', mktime(0,0,0,$payroll->month,1)) }} {{ $payroll->year }}
        </div>
    </div>

    <hr>

    {{-- Employee & Bank Details --}}
    <table class="two-col">
        <tr>
            <td class="col-left">
                <table class="details-table">
                    <tr>
                        <td>EMPLOYEE ID</td>
                        <td>{{ $payroll->employee->emp_id ?? auth()->user()->emp_id ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>EMPLOYEE NAME</td>
                        <td>{{ $payroll->employee_name ?? ($payroll->employee->name ?? '-') }}</td>
                    </tr>
                    <tr>
                        <td>DEPARTMENT</td>
                        <td>{{ $payroll->employee->department->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>DIVISION</td>
                        <td>{{ $payroll->team ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>LOCATION</td>
                        <td>{{ $payroll->employee->work_location ?? ($payroll->employee->branch->branch_name ?? '-') }}</td>
                    </tr>
                    <tr>
                        <td>DESIGNATION</td>
                        <td>{{ $payroll->employee->designation->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>DATE OF BIRTH</td>
                        <td>{{ $payroll->employee->dob ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>DATE OF JOINING</td>
                        <td>{{ $payroll->employee->joining_date ?? '-' }}</td>
                    </tr>
                </table>
            </td>
            <td class="col-right">
                <table class="details-table">
                    <tr>
                        <td>BANK NAME</td>
                        <td>{{ $payroll->bank ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>BANK A/C NO</td>
                        <td>{{ $payroll->bank_account_number ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>PAN NUMBER</td>
                        <td>{{ $payroll->employee->pan_no ?? ($payroll->employee->pan_number ?? '-') }}</td>
                    </tr>
                    <tr>
                        <td>PF UAN NO</td>
                        <td>{{ $payroll->employee->uan ?? ($payroll->employee->pf_number ?? '-') }}</td>
                    </tr>
                    <tr>
                        <td>EMAIL ID</td>
                        <td>{{ $payroll->employee->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>DAYS IN MONTH</td>
                        <td>{{ $payroll->days_in_month ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>DAYS PRESENT</td>
                        <td>{{ $payroll->present_days ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>WFH DAYS</td>
                        <td>{{ $payroll->wfh ?? '-' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- Earnings & Deductions --}}
    <table class="two-col" style="margin-top:14px;">
        <tr>
            {{-- Earnings --}}
            <td class="col-left">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Earnings</th>
                            <th class="text-end">Amount (INR)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Basic</td>
                            <td class="text-end">{{ number_format($payroll->basic ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td>House Rent Allowance</td>
                            <td class="text-end">{{ number_format($payroll->house_rent ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Conveyance Allowance</td>
                            <td class="text-end">{{ number_format($payroll->conveyance ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Other Allowance</td>
                            <td class="text-end">{{ number_format($payroll->other_allowance ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Medical Allowance</td>
                            <td class="text-end">{{ number_format($payroll->medical ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Telephone Allowance</td>
                            <td class="text-end">{{ number_format($payroll->telephone ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td>CEA</td>
                            <td class="text-end">{{ number_format($payroll->cea ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Performance Bonus</td>
                            <td class="text-end">{{ number_format($payroll->performance_bonus ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Project Allowance</td>
                            <td class="text-end">{{ number_format($payroll->project_allowance ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Special Allowance</td>
                            <td class="text-end">{{ number_format($payroll->special_allowance ?? 0, 2) }}</td>
                        </tr>
                        <tr class="total-row">
                            <td>Total Earnings</td>
                            <td class="text-end">{{ number_format($payroll->total_earnings ?? 0, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </td>

            {{-- Deductions --}}
            <td class="col-right">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Deductions</th>
                            <th class="text-end">Amount (INR)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Provident Fund</td>
                            <td class="text-end">{{ number_format($payroll->pf ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Professional Tax</td>
                            <td class="text-end">{{ number_format($payroll->professional_tax ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Income Tax</td>
                            <td class="text-end">{{ number_format($payroll->income_tax ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td>LWF</td>
                            <td class="text-end">{{ number_format($payroll->lwf ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td>ESI</td>
                            <td class="text-end">{{ number_format($payroll->esi ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Salary Advance Recovery</td>
                            <td class="text-end">{{ number_format($payroll->salary_deductions ?? 0, 2) }}</td>
                        </tr>
                        <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr class="total-row">
                            <td>Total Deductions</td>
                            <td class="text-end">{{ number_format($payroll->total_deduction ?? 0, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    {{-- Net Pay Box --}}
    <table class="net-pay-box">
        <tr>
            <td width="40%">
                <div class="np-label">NET PAY</div>
                <div class="np-amount">
                    &#8377; {{ number_format($payroll->net_salary ?? 0, 2) }}
                </div>
            </td>
            <td width="60%" class="np-right">
                <div>For the month of
                    {{ date('F', mktime(0,0,0,$payroll->month,1)) }} {{ $payroll->year }}
                </div>
                <div style="margin-top:4px;">
                    Credited to {{ $payroll->bank ?? '-' }} A/c
                    {{ $payroll->bank_account_number ?? '-' }}
                </div>
            </td>
        </tr>
    </table>

    <div class="footer-note">
        This is a computer generated payslip.
    </div>

</div>

</body>
</html>
