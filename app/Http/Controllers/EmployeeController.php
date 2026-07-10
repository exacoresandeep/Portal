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
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class EmployeeController extends Controller
{

    // Employee List Page
    public function index()
    {
        $jobTypes = JobType::where('status', 'active')->get();
        $departments = Department::where('status', 'active')->get();
        $designations = Designation::where('status', 'active')->get();
        $managers = Employee::where('status', '1')->get();

        return view(
            'pages.employee-list',
            compact(
                'jobTypes',
                'departments',
                'managers',
                'designations'
            )
        );
    }

    public function resetPassword($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([
                'status' => false,
                'message' => 'Employee not found.'
            ], 404);
        }

        // First 3 letters of name
        $namePart = ucfirst(strtolower(substr(trim($employee->name), 0, 3)));

        // Last 3 digits of contact number
        $phonePart = substr(preg_replace('/\D/', '', $employee->contact_no), -3);

        // Password Format: San@210
        $defaultPassword = $namePart . '@' . $phonePart;

        $employee->password = Hash::make($defaultPassword);
        $employee->save();

        return response()->json([
            'status' => true,
            'message' => 'Password has been reset successfully.',
            'password' => $defaultPassword // Optional: Remove this in production if you don't want to expose it.
        ]);
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
            class="btn btn-sm btn-primary"
            onclick="viewEmployee('.$row->id.')"  title="View">

        <i class="bi bi-eye"></i> 

    </button>

    <button type="button"
            class="btn btn-sm btn-warning text-white"
            onclick="editEmployee('.$row->id.')" title="Edit">

        <i class="bi bi-pencil-square"></i> 

    </button>

    <button type="button"
            class="btn btn-sm btn-danger"
            onclick="resetPassword('.$row->id.')" title="Reset Password">

        <i class="bi bi-key"></i>

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

    public function changePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:6'
        ]);

        $employee = Employee::findOrFail($id);

        $employee->password = Hash::make($request->password);
        $employee->save();

        return response()->json([
            'status' => true,
            'message' => 'Password changed successfully.'
        ]);
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

                                <i class="bi bi-eye"></i> 

                            </button>

                            <button type="button"
                                    class="btn btn-sm btn-warning text-white editEmployee"
                                    data-id="' . $row->id . '"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addEmployeeModal">

                                <i class="bi bi-pencil-square"></i> 

                            </button>
                            <button type="button"
                                    class="btn btn-sm btn-danger text-white "
                                    onClick="removeEmployee(' . $row->id . ')">

                                <i class="bi bi-trash"></i> 

                            </button>
                            <button type="button"
                                    class="btn btn-sm btn-success text-white "
                                    onClick="verifyEmployee(' . $row->id . ')">

                                <i class="bi bi-check"></i> 

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
    public function destroy($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([
                'status' => false,
                'message' => 'Employee not found.'
            ], 404);
        }

        $employee->delete();

        return response()->json([
            'status' => true,
            'message' => 'Employee deleted successfully.'
        ]);
    }
    public function employeeDetails($id)
    {
        $employee = Employee::with([
            'designation',
            'department',
            'reportingManager',
            'educations',
            'experiences'
        ])->findOrFail($id);
        $employee->photo_url = $employee->photo
            ? asset('storage/employees/photos/' . $employee->photo)
            : asset('assets/img/user.png');
        $employee->passbook = $employee->passbook
            ? asset('storage/employees/passbook/' . $employee->passbook)
            : "-";
        return response()->json($employee);
    }

    public function verifyEmployee($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {

            return response()->json([
                'status' => false,
                'message' => 'Employee not found.'
            ], 404);

        }

        if ($employee->onboard_status == 'Completed') {

            return response()->json([
                'status' => false,
                'message' => 'Employee is already verified.'
            ], 400);

        }

        $employee->onboard_status = 'Completed';
        $employee->save();

        return response()->json([
            'status' => true,
            'message' => 'Employee verified successfully.'
        ]);
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
        $namePrefix = ucfirst(strtolower(substr(trim($request->name), 0, 3)));
        $password = $namePrefix . '@123';

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
            'password' => Hash::make($password),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Employee added successfully',
            'password' => $password,

        ]);
    }
    // Edit Employee Page
    public function edit($id)
    {
        $employee= Employee::with([
            'department',
            'designation',
            'reportingManager',
            'educations',
            'experiences'
        ])->findOrFail($id);
         $employee->photo = $employee->photo
            ? asset('storage/employees/photos/' . $employee->photo)
            : asset('assets/img/user.png');
        return response()->json($employee);
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'id'    => 'required|exists:employees,id',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $employee = Employee::findOrFail($request->id);

        if ($request->hasFile('photo')) {
           
            // Delete old photo
            if (!empty($employee->photo) &&
                Storage::disk('public')->exists('employees/photos/' . $employee->photo)) {

                Storage::disk('public')->delete('employees/photos/' . $employee->photo);
            }

            // Generate filename
            $extension = $request->file('photo')->getClientOriginalExtension();

            $filename = now()->format('YmdHis') . '_' . $employee->id . '.' . $extension;

            // Store image
            $request->file('photo')->storeAs(
                'employees/photos',
                $filename,
                'public'
            );

            // Save filename only
            $employee->photo = $filename;
            $employee->save();
        }

        return response()->json([
            'status'=>true,
            'message'=>'Profile photo updated successfully.'
        ]);
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

    public function updateProfile(Request $request)
    {
        $employee = Employee::findOrFail($request->id);

        $validated = $request->validate([

            'name' => 'required|max:150',

            'emp_id' => [
                'required',
                Rule::unique('employees', 'emp_id')->ignore($employee->id)
            ],

            'email' => [
                'nullable',
                'email',
                Rule::unique('employees', 'personal_email')->ignore($employee->id)
            ],

            'phone' => 'required|digits_between:10,15',

            'dob' => 'nullable|date',

            'gender' => 'nullable',

            'blood_group' => 'nullable',

            'marital_status' => 'nullable',

            'guardian_name' => 'nullable|max:150',

            'address' => 'nullable',

            'nationality' => 'nullable',

            'emergency_phone' => 'nullable|digits_between:10,15',

        ]);

        $employee->update([

            'name' => $request->name,
            'emp_id' => $request->emp_id,
            'personal_email' => $request->email,
            'contact_no' => $request->phone,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'blood_group' => $request->blood_group,
            'marital_status' => $request->marital_status,
            'parent_name' => $request->guardian_name,
            'address' => $request->address,
            'nationality' => $request->nationality,
            'alt_contact_no' => $request->emergency_phone,

        ]);

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully.'
        ]);
    }


   public function updateOfficial(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:employees,id',
            'emp_id' => 'required|max:50',
            'official_email' => 'nullable|email|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'designation_id' => 'nullable|exists:designations,id',
            'reporting_manager' => 'nullable|exists:employees,id',
            'joining_date' => 'nullable|date',
            'job_type' => 'nullable|in:Permanent,Temporary,Trainee,Contract',
            'work_mode' => 'nullable|in:Office,Remote,Hybrid',
            'employee_status' => 'nullable|in:Active,Inactive,Resigned',
            'work_location' => 'nullable|string|max:255',
        ]);

        try {

            $employee = Employee::findOrFail($request->id);

            $employee->update([
                'emp_id'             => $request->emp_id,
                'official_email'     => $request->official_email,
                'department_id'      => $request->department_id,
                'designation_id'     => $request->designation_id,
                'reporting_manager_id'  => $request->reporting_manager,
                'joining_date'       => $request->joining_date,
                'job_type'           => $request->job_type,
                'work_mode'          => $request->work_mode,
                'employee_status'    => $request->employee_status,
                'work_location'      => $request->work_location,
                'status'      => $request->status,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Official information updated successfully.'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ],500);

        }
    }
    public function updateBank(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:employees,id',
            'account_no' => 'required',
            'bank_name' => 'required',
            'ifsc' => 'required',
            'branch' => 'required',
            'passbook' => 'nullable|mimes:pdf,png,jpg|max:5120'
        ]);

        try{

            $employee = Employee::findOrFail($request->id);

            $employee->account_no = $request->account_no;
            $employee->bank_name = $request->bank_name;
            $employee->ifsc = $request->ifsc;
            $employee->branch = $request->branch;

            if($request->hasFile('passbook')){
            // Delete old file
                if ($employee->passbook && Storage::disk('public')->exists('employees/passbook/' . $employee->passbook)) {
                    Storage::disk('public')->delete('employees/passbook/' . $employee->passbook);
                }

                $file = $request->file('passbook');

                // Example: 25_20260708_180530.pdf
                $fileName = $employee->id . '_' . Carbon::now()->format('Ymd_His') . '.' . $file->getClientOriginalExtension();

                // Store file
                $file->storeAs('employees/passbook', $fileName, 'public');

                // Save only filename in database
                $employee->passbook = $fileName;
            }

            $employee->save();

            return response()->json([
                'status'=>true,
                'message'=>'Bank details updated successfully.'
            ]);

        }catch(\Exception $e){

            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
            ],500);

        }
    }
}
