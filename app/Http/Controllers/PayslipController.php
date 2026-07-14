<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class PayslipController extends Controller
{
    /**
     * Employee Payslip Landing Page
     */
    public function index()
    {
        $employeeId = Auth::user()->id;

        $latest = Payroll::where('employee_id', $employeeId)
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->first();

        $summary = [
            'latest_salary' => $latest->net_salary ?? 0,
            'total_payslips' => Payroll::where('employee_id', $employeeId)->count(),
            'employee_id' => $employeeId,
            'latest_period' => $latest
                ? date('F', mktime(0,0,0,$latest->month,1)).' '.$latest->year
                : '-',
        ];

        return view(
            'pages.payslip.index',
            compact(
                'summary',
                'latest'
            )
        );
    }

    /**
     * Payslip DataTable
     */
    public function list(Request $request)
    {
        $employeeId = Auth::user()->id;
        // dd($employeeId);
        $query = Payroll::where('employee_id', $employeeId)

            ->when($request->year, function ($q) use ($request) {
                $q->where('year', $request->year);
            })

            ->when($request->month, function ($q) use ($request) {
                $q->where('month', $request->month);
            })

            ->orderByDesc('year')
            ->orderByDesc('month');

        return DataTables::of($query)

            ->addIndexColumn()

            ->addColumn('period', function ($row) {

                return date(
                    'F',
                    mktime(0,0,0,$row->month,1)
                ).' '.$row->year;

            })

            ->addColumn('gross', function ($row) {

                return number_format(
                    $row->total_earnings,
                    2
                );

            })

            ->addColumn('deduction', function ($row) {

                return number_format(
                    $row->total_deduction,
                    2
                );

            })

            ->addColumn('net', function ($row) {

                return number_format(
                    $row->net_salary,
                    2
                );

            })

            ->addColumn('status', function () {

                return '<span class="badge bg-success">
                            Paid
                        </span>';

            })

            ->addColumn('action', function ($row) {

                return '

                <button
                    class="btn btn-primary btn-sm viewPayslip"
                    data-id="'.$row->id.'">

                    <i class="bi bi-eye"></i>

                </button>

                <a
                    href="'.route(
                        'payslip.template.download',
                        $row->id
                    ).'"
                    class="btn btn-success btn-sm">

                    <i class="bi bi-download"></i>

                </a>

                ';

            })

            ->rawColumns([
                'status',
                'action'
            ])

            ->make(true);
    }

    /**
     * View Payslip
     */
    public function view($id)
    {
        $employeeId = Auth::user()->id;

        $payroll = Payroll::where('employee_id', $employeeId)
            ->findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $payroll
        ]);
    }
    
    public function summary()
    {
        $employeeId = Auth::user()->id;

        $latest = Payroll::where(
            'employee_id',
            $employeeId
        )

        ->orderByDesc('year')

        ->orderByDesc('month')

        ->first();

        return response()->json([
            'latest' => $latest,
            'total_count' => Payroll::where('employee_id', $employeeId)->count(),
        ]);
    }

    public function downloadTemplate($id)
    {
        $payroll = Payroll::with([
            'employee.designation',
            // 'employee.branch',
            'employee.department'
        ])->findOrFail($id);

        $pdf = Pdf::loadView('pages.payslip.pdf', compact('payroll'));

        $pdf->setPaper('A4', 'portrait');

        return $pdf->download(
            'Payslip_'.$payroll->month.'_'.$payroll->year.'.pdf'
        );
    }
}