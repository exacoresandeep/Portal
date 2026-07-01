<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Leave;
use App\Models\LeaveCount;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\LeaveCountExport;
use App\Exports\LeaveRequestExport;
use App\Exports\WfhRequestExport;
use Maatwebsite\Excel\Facades\Excel;

class LeaveController extends Controller
{
    /**
     * Store leave request
     */
    public function index()
    {
        return view('pages.leave.index');
    }

    public function leaveList(Request $request)
    {
        $query = Leave::with('employee');

        if ($request->filled('from_date')) {
            $query->whereDate('from_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('to_date', '<=', $request->to_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('leave_type')) {
            $query->where('leave_type', $request->leave_type);
        }
        if ($request->filled('manager_status')) {
            $query->where('manager_status', $request->manager_status);
        }
        $query->where('leave_type', "!=", "WFH");
        return datatables()
            ->of($query)

            ->addIndexColumn()

            ->addColumn('employee_name', function ($row) {
                return $row->employee->name ?? '-';
            })

            ->addColumn('employee_id', function ($row) {
                return $row->employee->emp_id ?? '-';
            })

            ->editColumn('from_date', function ($row) {
                return \Carbon\Carbon::parse($row->from_date)->format('d-m-Y');
            })

            ->editColumn('to_date', function ($row) {
                return \Carbon\Carbon::parse($row->to_date)->format('d-m-Y');
            })

            ->editColumn('created_at', function ($row) {
                return \Carbon\Carbon::parse($row->created_at)->format('d-m-Y');
            })

            ->addColumn('leave_count', function ($row) {
                return \Carbon\Carbon::parse($row->from_date)
                    ->diffInDays(\Carbon\Carbon::parse($row->to_date)) + 1;
            })

            ->addColumn('attachment', function ($row) {

                if (!$row->attachment) {
                    return '-';
                }

                $url = asset('storage/employees/leave_attachments/' . $row->attachment);

                return '
                    <a href="javascript:void(0)" class="btn btn-sm btn-warning me-1 view-image" data-image="' . $url . '" title="View">
                        <i class="bi bi-eye"></i>
                    </a>

                    <a href="' . $url . '" download class="btn btn-sm btn-primary" title="Download">
                        <i class="bi bi-download"></i>
                    </a>
                ';
            })
            ->addColumn('manager_status', function ($row) {

                if ($row->manager_status == 'Approved') {
                    return '<span class="badge bg-success">Approved</span>';
                }

                if ($row->manager_status == 'Rejected') {
                    return '<span class="badge bg-danger">Rejected</span>';
                }

                return '<span class="badge bg-warning text-dark">Pending</span>';
            })

            ->addColumn('action', function ($row) {

                if ($row->manager_status == 'Approved') {

                    return '
                        <button class="btn btn-success btn-sm approveLeave" data-id="' . $row->id . '">
                            Approve
                        </button>

                        <button class="btn btn-danger btn-sm rejectLeave" data-id="' . $row->id . '">
                            Reject
                        </button>
                    ';
                }

                if ($row->status == 'Approved') {
                    return '<span class="badge bg-success">Approved</span>';
                }

                return '<span class="badge bg-danger">Rejected</span>';
            })

            // Employee Name Search
            ->filterColumn('employee_name', function ($query, $keyword) {
                $query->whereHas('employee', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })

            // Employee ID Search
            ->filterColumn('employee_id', function ($query, $keyword) {
                $query->whereHas('employee', function ($q) use ($keyword) {
                    $q->where('emp_id', 'like', "%{$keyword}%");
                });
            })

            // From Date Search
            ->filterColumn('from_date', function ($query, $keyword) {

                $query->where(function ($q) use ($keyword) {

                    $q->whereRaw(
                        "DATE_FORMAT(from_date,'%d-%m-%Y') LIKE ?",
                        ["%{$keyword}%"]
                    )
                        ->orWhereDate('from_date', $keyword);
                });
            })

            // To Date Search
            ->filterColumn('to_date', function ($query, $keyword) {

                $query->where(function ($q) use ($keyword) {

                    $q->whereRaw(
                        "DATE_FORMAT(to_date,'%d-%m-%Y') LIKE ?",
                        ["%{$keyword}%"]
                    )
                        ->orWhereDate('to_date', $keyword);
                });
            })

            // Applied Date Search
            ->filterColumn('created_at', function ($query, $keyword) {

                $query->where(function ($q) use ($keyword) {

                    $q->whereRaw(
                        "DATE_FORMAT(created_at,'%d-%m-%Y') LIKE ?",
                        ["%{$keyword}%"]
                    )
                        ->orWhereDate('created_at', $keyword);
                });
            })

            ->rawColumns(['attachment', 'manager_status', 'action'])

            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'leave_type' => 'required|in:Sick,Casual,Earned,WFH,Maternity,LOP',
            'reason' => 'nullable|string',
            'attachment' => 'nullable|file|max:2048',
        ]);

        $attachment = null;

        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment')
                ->store('leave_attachments', 'public');
        }

        Leave::create([
            'employee_id' => Auth::id(),
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'leave_type' => $request->leave_type,
            'reason' => $request->reason,
            'attachment' => $attachment,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Leave request submitted successfully.'
        ]);
    }

    /**
     * Approve Leave
     */
    public function approve($id)
    {
        $leave = Leave::findOrFail($id);

        $leave->update([
            'status' => 'Approved',
            'action_date' => now(),
            'action_by' => Auth::id()
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Leave Approved Successfully'
        ]);
    }

    /**
     * Reject Leave
     */
    public function reject($id)
    {
        $leave = Leave::findOrFail($id);

        $leave->update([
            'status' => 'Rejected',
            'action_date' => now(),
            'action_by' => Auth::id()
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Leave Rejected Successfully'
        ]);
    }

    public function exportLeaveRequests(Request $request)
    {
        return Excel::download(
            new LeaveRequestExport($request->all()),
            'leave_requests_' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    public function wfh()
    {
        $designations = Designation::where('status', 'active')->get();
        return view(
            'pages.leave.wfh',
            compact(
                'designations'
            )
        );
    }

    public function wfhList(Request $request)
    {
        $query = Leave::with('employee.designation');

        if ($request->filled('from_date')) {
            $query->whereDate('from_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('to_date', '<=', $request->to_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('filter_designation')) {

            $query->whereHas('employee', function ($q) use ($request) {

                $q->where('designation_id', $request->filter_designation);
            });
        }
        if ($request->filled('manager_status')) {
            $query->where('manager_status', $request->manager_status);
        }
        $query->where('leave_type', "WFH");
        return datatables()
            ->of($query)

            ->addIndexColumn()

            ->addColumn('employee_name', function ($row) {
                return $row->employee->name ?? '-';
            })

            ->addColumn('employee_id', function ($row) {
                return $row->employee->emp_id ?? '-';
            })

            ->editColumn('from_date', function ($row) {
                return \Carbon\Carbon::parse($row->from_date)->format('d-m-Y');
            })

            ->editColumn('to_date', function ($row) {
                return \Carbon\Carbon::parse($row->to_date)->format('d-m-Y');
            })

            ->editColumn('created_at', function ($row) {
                return \Carbon\Carbon::parse($row->created_at)->format('d-m-Y');
            })
            ->addColumn('designation', function ($row) {
                return $row->employee?->designation?->name ?? '-';
            })
            ->addColumn('manager_status', function ($row) {

                if ($row->manager_status == 'Approved') {
                    return '<span class="badge bg-success">Approved</span>';
                }

                if ($row->manager_status == 'Rejected') {
                    return '<span class="badge bg-danger">Rejected</span>';
                }

                return '<span class="badge bg-warning text-dark">Pending</span>';
            })
            ->addColumn('action', function ($row) {

                if ($row->manager_status == 'Approved') {

                    return '
                        <button class="btn btn-success btn-sm approveLeave" data-id="' . $row->id . '">
                            Approve
                        </button>

                        <button class="btn btn-danger btn-sm rejectLeave" data-id="' . $row->id . '">
                            Reject
                        </button>
                    ';
                }

                if ($row->status == 'Approved') {
                    return '<span class="badge bg-success">Approved</span>';
                }

                return '<span class="badge bg-danger">Rejected</span>';
            })

            // Employee Name Search
            ->filterColumn('employee_name', function ($query, $keyword) {
                $query->whereHas('employee', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })

            // Employee ID Search
            ->filterColumn('employee_id', function ($query, $keyword) {
                $query->whereHas('employee', function ($q) use ($keyword) {
                    $q->where('emp_id', 'like', "%{$keyword}%");
                });
            })

            // From Date Search
            ->filterColumn('from_date', function ($query, $keyword) {

                $query->where(function ($q) use ($keyword) {

                    $q->whereRaw(
                        "DATE_FORMAT(from_date,'%d-%m-%Y') LIKE ?",
                        ["%{$keyword}%"]
                    )
                        ->orWhereDate('from_date', $keyword);
                });
            })

            // To Date Search
            ->filterColumn('to_date', function ($query, $keyword) {

                $query->where(function ($q) use ($keyword) {

                    $q->whereRaw(
                        "DATE_FORMAT(to_date,'%d-%m-%Y') LIKE ?",
                        ["%{$keyword}%"]
                    )
                        ->orWhereDate('to_date', $keyword);
                });
            })

            // Applied Date Search
            ->filterColumn('created_at', function ($query, $keyword) {

                $query->where(function ($q) use ($keyword) {

                    $q->whereRaw(
                        "DATE_FORMAT(created_at,'%d-%m-%Y') LIKE ?",
                        ["%{$keyword}%"]
                    )
                        ->orWhereDate('created_at', $keyword);
                });
            })
            ->filterColumn('designation', function ($query, $keyword) {
                $query->whereHas('employee.designation', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('manager_status', function ($query, $keyword) {
                $query->where('manager_status', 'like', "%{$keyword}%");
            })
            ->rawColumns(['manager_status', 'action'])

            ->make(true);
    }

    public function wfhStore(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'leave_type' => 'required|in:Sick,Casual,Earned,WFH,Maternity,LOP',
            'reason' => 'nullable|string',
        ]);

        $attachment = null;

        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment')
                ->store('leave_attachments', 'public');
        }

        Leave::create([
            'employee_id' => Auth::id(),
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'leave_type' => $request->leave_type,
            'reason' => $request->reason,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'WFH request submitted successfully.'
        ]);
    }

    /**
     * Approve Leave
     */
    public function wfhApprove($id)
    {
        $leave = Leave::findOrFail($id);

        $leave->update([
            'status' => 'Approved',
            'action_date' => now(),
            'action_by' => Auth::id()
        ]);

        return response()->json([
            'status' => true,
            'message' => 'WFH Request Approved Successfully'
        ]);
    }

    /**
     * Reject Leave
     */
    public function wfhReject($id)
    {
        $leave = Leave::findOrFail($id);

        $leave->update([
            'status' => 'Rejected',
            'action_date' => now(),
            'action_by' => Auth::id()
        ]);

        return response()->json([
            'status' => true,
            'message' => 'WFH Request Rejected Successfully'
        ]);
    }

    public function exportWfhRequests(Request $request)
    {
        return Excel::download(
            new WfhRequestExport($request->all()),
            'wfh_requests_' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    public function leavecount()
    {
        $departments = Department::where('status', 'active')->get();
        return view(
            'pages.leave.leavecount',
            compact(
                'departments'
            )
        );
    }

    public function leavecountList(Request $request)
    {
        $year = $request->year ?? date('Y');

        $query = LeaveCount::with(['employee.department'])

            ->where('year', $year);

        if ($request->filled('department_id')) {

            $query->whereHas('employee', function ($q) use ($request) {

                $q->where('department_id', $request->department_id);
            });
        }

        return datatables()
            ->of($query)

            ->addIndexColumn()

            ->addColumn('employee_name', function ($row) {
                return $row->employee?->name ?? '-';
            })

            ->addColumn('employee_id', function ($row) {
                return $row->employee?->emp_id ?? '-';
            })

            ->addColumn('department', function ($row) {
                return $row->employee?->department?->name ?? '-';
            })

            ->addColumn('year', function ($row) {
                return $row->year;
            })

            ->addColumn('total_leave', function ($row) {

                return $row->sick_leaves
                    + $row->casual_leaves
                    + $row->earned_leaves;
            })

            ->addColumn('used_leave', function ($row) {

                return Leave::where('employee_id', $row->employee_id)
                    ->whereYear('from_date', $row->year)
                    ->where('status', 'Approved')
                    ->count();
            })

            ->addColumn('balance_leave', function ($row) {

                $total =
                    $row->sick_leaves +
                    $row->casual_leaves +
                    $row->earned_leaves;

                $used = Leave::where('employee_id', $row->employee_id)
                    ->whereYear('from_date', $row->year)
                    ->where('status', 'Approved')
                    ->count();

                return $total - $used;
            })

            ->addColumn('sick_leave', function ($row) {

                $taken = Leave::where('employee_id', $row->employee_id)
                    ->where('leave_type', 'Sick')
                    ->where('status', 'Approved')
                    ->whereYear('from_date', $row->year)
                    ->count();

                $balance = $row->sick_leaves - $taken;

                return $balance . ' / ' . $row->sick_leaves;
            })

            ->addColumn('casual_leave', function ($row) {

                $taken = Leave::where('employee_id', $row->employee_id)
                    ->where('leave_type', 'Casual')
                    ->where('status', 'Approved')
                    ->whereYear('from_date', $row->year)
                    ->count();

                $balance = $row->casual_leaves - $taken;

                return $balance . ' / ' . $row->casual_leaves;
            })

            ->addColumn('earned_leave', function ($row) {

                $taken = Leave::where('employee_id', $row->employee_id)
                    ->where('leave_type', 'Earned')
                    ->where('status', 'Approved')
                    ->whereYear('from_date', $row->year)
                    ->count();

                $balance = $row->earned_leaves - $taken;

                return $balance . ' / ' . $row->earned_leaves;
            })
            ->filterColumn('employee_name', function ($query, $keyword) {
                $query->whereHas('employee', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })

            // Employee ID Search
            ->filterColumn('employee_id', function ($query, $keyword) {
                $query->whereHas('employee', function ($q) use ($keyword) {
                    $q->where('emp_id', 'like', "%{$keyword}%");
                });
            })

            ->make(true);
    }

    public function exportLeaveCounts(Request $request)
    {
        $year = $request->year ?? date('Y');
        $departmentId = $request->department_id;

        return Excel::download(
            new LeaveCountExport($year, $departmentId),
            'leave-count-report.xlsx'
        );
    }
}
