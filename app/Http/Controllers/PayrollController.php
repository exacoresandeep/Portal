<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\PayrollImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Payroll;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\PayrollTemplateExport;

class PayrollController extends Controller
{
    /**
     * Payroll Listing
     */
    public function index()
    {
        return view('pages.payroll.index');
    }

    public function downloadTemplate()
    {
        return Excel::download(
            new PayrollTemplateExport(),
            'Payroll_Template.xlsx'
        );
    }

    public function list(Request $request)
    {
        $year = $request->year ?: date('Y');
        $month = $request->month ?: date('n');

        $query = Payroll::query()
            ->where('year', $year)
            ->where('month', $month);

        return DataTables::of($query)

            ->addIndexColumn()

            ->addColumn('month_name', function ($row) {

                return date(
                    'F',
                    mktime(0, 0, 0, $row->month, 1)
                );
            })

            ->addColumn('action', function ($row) {

                return '
                    <button class="btn btn-info btn-sm viewPayroll"
                        data-id="' . $row->id . '">
                        <i class="bi bi-eye"></i>
                    </button>

                    <button class="btn btn-warning btn-sm editPayroll"
                        data-id="' . $row->id . '">
                        <i class="bi bi-pencil"></i>
                    </button>

                    <button class="btn btn-danger btn-sm deletePayroll"
                        data-id="' . $row->id . '">
                        <i class="bi bi-trash"></i>
                    </button>
                ';
            })

            ->rawColumns(['action'])

            ->make(true);
    }


    public function import(Request $request)
    {
        $import = new PayrollImport(
            $request->year,
            $request->month
        );

        Excel::import($import, $request->file('file'));

        return response()->json([
            'status'   => true,
            'inserted' => $import->inserted,
            'updated'  => $import->updated,
            'message'  => "{$import->inserted} records inserted and {$import->updated} records updated successfully."
        ]);
    }



    public function view($id)
    {
        $payroll = Payroll::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $payroll
        ]);
    }


    public function edit($id)
    {
        $payroll = Payroll::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $payroll
        ]);
    }

    public function update(Request $request, $id)
    {
        $payroll = Payroll::findOrFail($id);

        $payroll->update($request->except([
            '_token'
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Payroll updated successfully'
        ]);
    }


    public function delete($id)
    {
        Payroll::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Payroll deleted successfully.'
        ]);
    }
}
