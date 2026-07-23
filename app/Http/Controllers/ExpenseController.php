<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ExpenseController extends Controller
{
    public function index()
    {
        return view('pages.expense.index');
    }


    public function delete(Request $request)
    {
        $expense = Expense::where('id', $request->id)
            ->where('employee_id', Auth::id())
            ->where('status', 'Pending')
            ->first();

        if (!$expense) {
            return response()->json([
                'status' => false,
                'message' => 'Expense request not found or cannot be removed.'
            ]);
        }

        $expense->delete();

        return response()->json([
            'status' => true,
            'message' => 'Expense request removed successfully.'
        ]);
    }

    public function list(Request $request)
    {
        $data = Expense::with([
            'employee.department'
        ])->when(
            !in_array(Auth::user()->department_id, [1, 2]),
            function ($q) {
                $q->where('employee_id', Auth::id());
            }
        )->orderBy('id', 'desc');

        if ($request->filled('year')) {

            $data->whereYear(
                'created_at',
                $request->year
            );
        }

        if ($request->filled('month')) {

            $month = Carbon::parse(
                '1 ' . $request->month
            )->month;

            $data->whereMonth(
                'created_at',
                $month
            );
        }

        if ($request->filled('status')) {

            $data->where(
                'status',
                $request->status
            );
        }

        return DataTables::of($data)

            ->addIndexColumn()

            ->addColumn('employee_name', function ($row) {
                return $row->employee->name ?? '';
            })

            ->addColumn('employee_code', function ($row) {
                return $row->employee->emp_id ?? '';
            })

            ->addColumn('department', function ($row) {
                return $row->employee->department->name ?? '';
            })

            ->editColumn('amount', function ($row) {
                return number_format(
                    $row->amount,
                    2
                );
            })

            ->editColumn('created_at', function ($row) {
                return Carbon::parse(
                    $row->created_at
                )->format('d-m-Y');
            })


            ->addColumn('document_link', function ($row) {

                if (!$row->document) {
                    return '-';
                }

                $url = asset('storage/employees/expense_attachments/' . $row->document);

                return '
                    <a href="javascript:void(0)" class="btn btn-sm btn-warning me-1 view-image" data-image="' . $url . '" title="View">
                        <i class="bi bi-eye"></i>
                    </a>

                    <a href="' . $url . '" download class="btn btn-sm btn-primary" title="Download">
                        <i class="bi bi-download"></i>
                    </a>
                ';
            })

            ->addColumn('action', function ($row) {

                if ($row->status == 'pending') {
                     if(in_array(Auth::user()->department_id, [1, 2]))
                    {
                    return '
                        <button
                            class="btn btn-success btn-sm approveBtn"
                            data-id="' . $row->id . '">
                            Approve
                        </button>

                        <button
                            class="btn btn-danger btn-sm rejectBtn"
                            data-id="' . $row->id . '">
                            Reject
                        </button>
                        <button class="btn btn-danger btn-sm deleteExpense" data-id="' . $row->id . '">
                            Remove
                        </button>
                    ';
                    }
                    else{
                         return '<button class="btn btn-danger btn-sm deleteExpense" data-id="' . $row->id . '">
                                Remove
                            </button>';
                    }
                }

                return '-';
            })
            ->editColumn('status', function ($row) {

                if ($row->status == 'approved') {
                    return '<span class="badge bg-success">Approved</span>';
                }

                if ($row->status == 'rejected') {
                    return '<span class="badge bg-danger">Rejected</span>';
                }

                return '<span class="badge bg-warning">Pending</span>';
            })
            ->rawColumns(['status', 'document_link', 'action'])

            ->make(true);
    }
    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'status' => 'required|in:approved,rejected'
        ]);

        $expense = Expense::findOrFail($request->id);

        $expense->status = $request->status;
        $expense->action_at = Carbon::now();

        $expense->save();

        return response()->json([
            'status' => true,
            'message' => 'Expense ' . $request->status . ' successfully'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'expense_date'=>'required|date',
            'amount'=>'required|numeric|min:1',
            'purpose'=>'required|string',
            'document'=>'required|mimes:jpg,jpeg,png,pdf|max:4096'
        ]);

        $document = null;
        if($request->hasFile('document')){
            $file = $request->file('document');
            $document =
                'EXP_'.
                Auth::id().'_'.
                now()->format('YmdHis').'.'.
                $file->getClientOriginalExtension();

            $file->storeAs(
                'employees/expense_attachments',
                $document,
                'public'
            );
        }

        Expense::create([
            'employee_id'=>Auth::id(),
            'expense_date'=>$request->expense_date,
            'amount'=>$request->amount,
            'purpose'=>$request->purpose,
            'document'=>$document,
            'status'=>'pending'
        ]);

        return response()->json([
            'status'=>true,
            'message'=>'Expense Request Submitted Successfully.'
        ]);
    }
}
