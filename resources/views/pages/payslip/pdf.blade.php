<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <title>Payslip</title>

    <style>

        *{
            margin:5;
            box-sizing:border-box;
        }

        body{

            font-family: DejaVu Sans, sans-serif;
            font-size:12px;
            color:#222;
            line-height:1.4;

        }

        .container{

            width:98%;

        }

        table{

            width:98%;
            border-collapse:collapse;

        }

        td,th{

            padding:6px;

        }

        .text-center{

            text-align:center;

        }

        .text-right{

            text-align:right;

        }

        .text-left{

            text-align:left;

        }

        .fw-bold{

            font-weight:bold;

        }

        .small{

            font-size:11px;

        }

        .border{

            border:1px solid #000;

        }

        .border-top{

            border-top:1px solid #000;

        }

        .border-bottom{

            border-bottom:1px solid #000;

        }

        .bg-light{

            background:#efefef;

        }

        .heading{

            font-size:22px;
            font-weight:bold;

        }

        .company{

            font-size:18px;
            font-weight:bold;

        }

        .section-title{

            background:#d9d9d9;
            font-weight:bold;
            padding:8px;

        }

        .mt10{

            margin-top:10px;

        }

        .mt20{

            margin-top:20px;

        }

        .mb10{

            margin-bottom:10px;

        }

        .salary-box{

            border:1px solid #000;

        }

        .salary-box td{

            border:1px solid #000;

        }

        .highlight{

            font-size:22px;
            font-weight:bold;
            color:#006400;

        }

    </style>

</head>

<body>

<div class="container">

    <!-- Company Header -->

    <table>

        <tr>

            <td width="18%">

                {{-- Company Logo --}}
                {{-- <img src="{{ public_path('logo.png') }}" width="80"> --}}

            </td>

            <td width="82%" class="text-center">

                <div class="company">
                    EXACORE IT SOLUTIONS PVT LTD
                </div>

                <div class="small">
                    1st Floor, Indeevaram Bldg, Infopark Smart Space, 
                    Koratty, Thrissur - 680308
                </div>

                <div class="small">
                    Email :
                    info@exacoreitsolutions.com
                    |
                    Phone :
                    +91 8138916160

                </div>

            </td>

        </tr>

    </table>

    <br>

    <table>

        <tr>

            <td class="text-center heading">

                PAY SLIP

            </td>

        </tr>

    </table>

    <br>

    <!-- Employee Details -->

    <table class="border">

        <tr class="bg-light">

            <th colspan="4">

                Employee Details

            </th>

        </tr>

        <tr>

            <td width="22%">
                Employee Name
            </td>

            <td width="28%">
                {{ $payroll->employee_name }}
            </td>

            <td width="22%">
                Employee ID
            </td>

            <td width="28%">
                {{ auth()->user()->emp_id }}
            </td>

        </tr>

        <tr>

            <td>
                Payroll Month
            </td>

            <td>

                {{ date('F',mktime(0,0,0,$payroll->month,1)) }}
                {{ $payroll->year }}

            </td>

            <td>
                Gender
            </td>

            <td>
                {{ $payroll->gender }}
            </td>

        </tr>

        <tr>

            <td>
                Team
            </td>

            <td>
                {{ $payroll->team }}
            </td>

            <td>
                Billing Unit
            </td>

            <td>
                {{ $payroll->billing_unit }}
            </td>

        </tr>

        <tr>

            <td>
                Bank
            </td>

            <td>
                {{ $payroll->bank }}
            </td>

            <td>
                Account No
            </td>

            <td>
                {{ $payroll->bank_account_number }}
            </td>

        </tr>

        <tr>

            <td>
                IFSC
            </td>

            <td colspan="3">

                {{ $payroll->ifsc_code }}

            </td>

        </tr>

    </table>

    <br>

    <!-- Net Salary Summary -->

    <table class="salary-box">

        <tr>

            <td width="70%">

                <strong>

                    Net Salary Payable

                </strong>

            </td>

            <td width="30%" class="text-center">

                <span class="highlight">

                    ₹ {{ number_format($payroll->net_salary,2) }}

                </span>

            </td>

        </tr>

    </table>

    <br>

        <!-- Earnings & Deductions -->

    <table style="width:100%;">

        <tr>

            <!-- Earnings -->

            <td width="50%" valign="top">

                <table class="border">

                    <tr class="bg-light">

                        <th colspan="2">
                            Earnings
                        </th>

                    </tr>

                    <tr>

                        <td>Basic Salary</td>

                        <td class="text-right">
                            ₹ {{ number_format($payroll->basic,2) }}
                        </td>

                    </tr>

                    <tr>

                        <td>Other Allowance</td>

                        <td class="text-right">
                            ₹ {{ number_format($payroll->other_allowance,2) }}
                        </td>

                    </tr>

                    <tr>

                        <td>Performance Bonus</td>

                        <td class="text-right">
                            ₹ {{ number_format($payroll->performance_bonus,2) }}
                        </td>

                    </tr>

                    <tr>

                        <td>Project Allowance</td>

                        <td class="text-right">
                            ₹ {{ number_format($payroll->project_allowance,2) }}
                        </td>

                    </tr>

                    <tr>

                        <td>Special Allowance</td>

                        <td class="text-right">
                            ₹ {{ number_format($payroll->special_allowance,2) }}
                        </td>

                    </tr>

                    <tr class="bg-light">

                        <th>Total Earnings</th>

                        <th class="text-right">
                            ₹ {{ number_format($payroll->total_earnings,2) }}
                        </th>

                    </tr>

                </table>

            </td>

            <td width="2%"></td>

            <!-- Deductions -->

            <td width="48%" valign="top">

                <table class="border">

                    <tr class="bg-light">

                        <th colspan="2">
                            Deductions
                        </th>

                    </tr>

                    <tr>

                        <td>Professional Tax</td>

                        <td class="text-right">
                            ₹ {{ number_format($payroll->professional_tax,2) }}
                        </td>

                    </tr>

                    <tr>

                        <td>Provident Fund (PF)</td>

                        <td class="text-right">
                            ₹ {{ number_format($payroll->pf,2) }}
                        </td>

                    </tr>

                    <tr>

                        <td>Income Tax</td>

                        <td class="text-right">
                            ₹ {{ number_format($payroll->income_tax,2) }}
                        </td>

                    </tr>

                    <tr>

                        <td>ESI</td>

                        <td class="text-right">
                            ₹ {{ number_format($payroll->esi,2) }}
                        </td>

                    </tr>

                    <tr>

                        <td>LWF</td>

                        <td class="text-right">
                            ₹ {{ number_format($payroll->lwf,2) }}
                        </td>

                    </tr>

                    <tr>

                        <td>Salary Deduction</td>

                        <td class="text-right">
                            ₹ {{ number_format($payroll->salary_deductions,2) }}
                        </td>

                    </tr>

                    <tr class="bg-light">

                        <th>Total Deduction</th>

                        <th class="text-right">
                            ₹ {{ number_format($payroll->total_deduction,2) }}
                        </th>

                    </tr>

                </table>

            </td>

        </tr>

    </table>

    <br>

    <!-- Net Pay Summary -->

    <table class="border">

        <tr class="bg-light">

            <th width="70%">
                Net Salary Payable
            </th>

            <th width="30%" class="text-right">
                ₹ {{ number_format($payroll->net_salary,2) }}
            </th>

        </tr>

    </table>

    <br>
        <!-- Attendance Details -->

    <table class="border">

        <tr class="bg-light">

            <th colspan="4">

                Attendance Details

            </th>

        </tr>

        <tr>

            <td width="25%">
                Days in Month
            </td>

            <td width="25%">
                {{ $payroll->days_in_month }}
            </td>

            <td width="25%">
                Present Days
            </td>

            <td width="25%">
                {{ $payroll->present_days }}
            </td>

        </tr>

        <tr>

            <td>
                Daily Rate
            </td>

            <td>
                ₹ {{ number_format($payroll->daily_rate,2) }}
            </td>

            <td>
                Net Payment
            </td>

            <td>
                ₹ {{ number_format($payroll->net_payment,2) }}
            </td>

        </tr>

        <tr>

            <td>
                Advance
            </td>

            <td>
                ₹ {{ number_format($payroll->advance,2) }}
            </td>

            <td>
                Recovery
            </td>

            <td>
                ₹ {{ number_format($payroll->recovery,2) }}
            </td>

        </tr>

        <tr>

            <td>
                Balance
            </td>

            <td>
                ₹ {{ number_format($payroll->balance,2) }}
            </td>

            <td>
                WFH
            </td>

            <td>
                {{ $payroll->wfh }}
            </td>

        </tr>

        <tr>

            <td>
                Project Bonus Days
            </td>

            <td>
                {{ $payroll->project_bonus_days }}
            </td>

            <td>
                Project Days Available
            </td>

            <td>
                {{ $payroll->project_days_available }}
            </td>

        </tr>

        <tr>

            <td>
                Per Day Deduction
            </td>

            <td>
                ₹ {{ number_format($payroll->per_day_deduction,2) }}
            </td>

            <td>
                Total Deduction 2
            </td>

            <td>
                ₹ {{ number_format($payroll->total_deduction_2,2) }}
            </td>

        </tr>

    </table>

    <br>

    <!-- Bank Details -->

    <table class="border">

        <tr class="bg-light">

            <th colspan="4">

                Bank Details

            </th>

        </tr>

        <tr>

            <td width="25%">
                Bank Name
            </td>

            <td width="25%">
                {{ $payroll->bank }}
            </td>

            <td width="25%">
                IFSC Code
            </td>

            <td width="25%">
                {{ $payroll->ifsc_code }}
            </td>

        </tr>

        <tr>

            <td>
                Account Number
            </td>

            <td colspan="3">

                {{ $payroll->bank_account_number }}

            </td>

        </tr>

    </table>

    <br><br>

    <!-- Footer -->

    <table>

        <tr>

            <td width="60%">

                <strong>Remarks</strong>

                <br><br>

                This is a computer generated payslip and does not require a signature.

            </td>

            <td width="40%" class="text-center">

                <br><br><br>

                _______________________

                <br>

                Authorized Signatory

            </td>

        </tr>

    </table>

    <br>

    <div style="text-align:center;font-size:10px;color:#777;">

        Generated on {{ now()->format('d M Y h:i A') }}

    </div>

</div>

</body>

</html>