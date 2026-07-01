<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use App\Models\JobType;
use App\Models\Department;
use App\Models\Designation;
use App\Exports\EmployeeExport;
use App\Exports\OnboardEmployeeExport;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{

    // Employee List Page
    public function index()
    {
        $jobTypes = JobType::where('status', 'active')->get();
        $departments = Department::where('status', 'active')->get();
        $designations = Designation::where('status', 'active')->get();

        return view(
            'pages.employee-list',
            compact(
                'jobTypes',
                'departments',
                'designations'
            )
        );
    }

    // DataTable Ajax
    public function employeeList(Request $request)
    {

        if ($request->ajax()) {

            $employees = Employee::with([
                'reportingManager',
                'designation',
                'department'
            ])

                ->when($request->status != '', function ($query) use ($request) {

                    $query->where('status', $request->status);
                })

                ->when($request->job_type != '', function ($query) use ($request) {

                    $query->where('job_type', $request->job_type);
                })

                ->when($request->department_id != '', function ($query) use ($request) {

                    $query->where('department_id', $request->department_id);
                })

                ->when($request->designation_id != '', function ($query) use ($request) {
                    $query->where('designation_id', $request->designation_id);
                })
                ->where("onboard_status", "Completed")
                ->latest();

            return DataTables::of($employees)

                ->addIndexColumn()

                ->addColumn('employee_name', function ($row) {

                    return $row->name;
                })

                ->addColumn('status_badge', function ($row) {

                    if ($row->status == 1) {

                        return '<span class="badge text-bg-success">
                                    Active
                                </span>';
                    } else {

                        return '<span class="badge text-bg-danger">
                        In Active
                        </span>';
                    }
                })

                ->addColumn('reporting_manager', function ($row) {

                    return $row->reportingManager->name ?? '-';
                })

                ->addColumn('designation_name', function ($row) {

                    return $row->designation->name ?? '-';
                })
                ->addColumn('action', function ($row) {

                    $editUrl = route('employees.edit', $row->id);

                    return '

                    <div class="d-flex gap-1">
                    <button type="button"
                    class="btn btn-sm btn-primary" onClick="viewEmployee(' . $row->id . ')">
                    
                    View

                    </button>
                    <a href="' . $editUrl . '"
                    class="btn btn-sm btn-warning text-white">
                    
                    Edit
                    
                            </a>

                        </div>
                        
                        ';
                })

                ->rawColumns([
                    'status_badge',
                    'onboard_badge',
                    'action'
                ])

                ->make(true);
        }
    }

    public function exportEmployees(Request $request)
    {
        return Excel::download(

            new EmployeeExport(

                $request->status,

                $request->job_type,

                $request->department_id,

                $request->designation_id

            ),

            'employees.xlsx'
        );
    }

    public function employeeDirectory()
    {
        $jobTypes = JobType::where('status', 'active')->get();
        $departments = Department::where('status', 'active')->get();
        $designations = Designation::where('status', 'active')->get();
        $managers = Employee::where('status', '1')->get();
        return view(
            'pages.onboard-list',
            compact(
                'jobTypes',
                'departments',
                'designations',
                'managers'

            )
        );
    }

    public function employeeOnboardList(Request $request)
    {
        if ($request->ajax()) {

            $employees = Employee::with([
                'reportingManager',
                'designation',
                'department'
            ])

                ->when($request->status != '', function ($query) use ($request) {

                    $query->where('status', $request->status);
                })

                ->when($request->onboard_status != '', function ($query) use ($request) {

                    $query->where('onboard_status', $request->onboard_status);
                })

                ->when($request->job_type != '', function ($query) use ($request) {

                    $query->where('job_type', $request->job_type);
                })

                ->when($request->department_id != '', function ($query) use ($request) {

                    $query->where('department_id', $request->department_id);
                })

                ->when($request->designation_id != '', function ($query) use ($request) {

                    $query->where('designation_id', $request->designation_id);
                })
                ->where("onboard_status", "!=", "Completed")
                ->latest();

            return DataTables::of($employees)

                ->addIndexColumn()

                ->addColumn('employee_name', function ($row) {

                    return $row->name;
                })

                ->addColumn('designation_name', function ($row) {

                    return $row->designation->name ?? '-';
                })

                ->addColumn('reporting_manager', function ($row) {

                    return $row->reportingManager->name ?? '-';
                })

                ->addColumn('status_badge', function ($row) {

                    if ($row->status == 1) {

                        return '<span class="badge text-bg-success">
                                    Active
                                </span>';
                    } else {

                        return '<span class="badge text-bg-danger">
                                    Inactive
                                </span>';
                    }
                })

                ->addColumn('onboard_badge', function ($row) {

                    if ($row->onboard_status == 'Pending') {

                        return '<span class="badge text-bg-warning">
                                    Pending
                                </span>';
                    } elseif ($row->onboard_status == 'Completed') {

                        return '<span class="badge text-bg-success">
                                    Completed
                                </span>';
                    } else {

                        return '<span class="badge text-bg-primary">
                                    Profile Created
                                </span>';
                    }
                })

                ->addColumn('action', function ($row) {

                    $editUrl = route('employees.edit', $row->id);

                    return '

                        <div class="d-flex gap-1">

                            <button type="button"
                                    class="btn btn-sm btn-primary viewEmployee"
                                    data-id="' . $row->id . '"
                                    data-bs-toggle="modal"
                                    data-bs-target="#viewEmployeeModal">

                                View

                            </button>

                            <button type="button"
                                    class="btn btn-sm btn-warning text-white editEmployee"
                                    data-id="' . $row->id . '"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addEmployeeModal">

                                Edit

                            </button>

                        </div>

                    ';
                })

                ->rawColumns([
                    'status_badge',
                    'onboard_badge',
                    'action'
                ])

                ->make(true);
        }
    }

    public function employeeDetails($id)
    {
        $employee = Employee::with([
            'designation',
            'department',
            'reportingManager'
        ])->findOrFail($id);
        $employee->photo_url = $employee->photo
            ? asset('storage/employees/photos/' . $employee->photo)
            : asset('assets/img/user.png');
        return response()->json($employee);
    }

    public function onboardExport(Request $request)
    {
        return Excel::download(

            new OnboardEmployeeExport(
                $request->status,
                $request->job_type,
                $request->department_id,
                $request->designation_id,
                $request->onboard_status
            ),

            'onboard-employees.xlsx'
        );
    }
    // Add Employee
    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required',

            'email' => 'required|email|unique:employees,email',

            'emp_id' => 'required|unique:employees,emp_id',

            'department_id' => 'required',

            'designation_id' => 'required',

            'job_type' => 'required',

        ]);

        Employee::create([

            'name' => $request->name,

            'email' => $request->email,

            'emp_id' => $request->emp_id,

            'department_id' => $request->department_id,

            'designation_id' => $request->designation_id,

            'job_type' => $request->job_type,

            'reporting_manager_id' => $request->reporting_manager_id,

            'joining_date' => $request->joining_date,
            'confirm_date' => $request->confirm_date,

            'status' => 1,

            'onboard_status' => 'Pending',

            'password' => Hash::make('password'),

        ]);

        return response()->json([

            'status' => true,

            'message' => 'Employee added successfully'

        ]);
    }
    // Edit Employee Page
    public function edit($id)
    {

        $employee = Employee::findOrFail($id);

        $managers = Employee::where('id', '!=', $id)->get();

        return view(
            'pages.employee-edit',
            compact('employee', 'managers')
        );
    }
    // Update Employee
    public function update(Request $request, $id)
    {

        $employee = Employee::findOrFail($id);

        $request->validate([

            'name' => 'required',

            'email' => 'required|email|unique:employees,email,' . $id,

        ]);

        $employee->update([

            'name' => $request->name,

            'email' => $request->email,

            'emp_id' => $request->emp_id,

            'dob' => $request->dob,

            'designation' => $request->designation,

            'contact_no' => $request->contact_no,

            'alt_contact_no' => $request->alt_contact_no,

            'type' => $request->type,

            'job_type' => $request->job_type,

            'reporting_manager_id' => $request->reporting_manager_id,

            'joining_date' => $request->joining_date,
            'confirm_date' => $request->confirm_date,

            'pan_no' => $request->pan_no,

            'aadhar_no' => $request->aadhar_no,

            'status' => $request->status,

        ]);

        if ($request->password) {

            $employee->update([

                'password' => Hash::make($request->password)

            ]);
        }

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee updated successfully');
    }
    // Delete Employee
    public function destroy($id)
    {

        Employee::findOrFail($id)->delete();

        return redirect()
            ->back()
            ->with('success', 'Employee deleted successfully');
    }

    public function employeesByDepartment(Request $request)
    {
        return Employee::where(
            'department_id',
            $request->department_id
        )
            ->select('id', 'name')
            ->get();
    }

    public function getActiveEmployees()
    {
        $employees = Employee::with([
            'department',
            'designation',
            'reportingManager'
        ])
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        return response()->json($employees);
    }
}
