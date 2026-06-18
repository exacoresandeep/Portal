<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Project;
use Yajra\DataTables\Facades\DataTables;
  use App\Exports\ProjectsExport;
use Maatwebsite\Excel\Facades\Excel;

class ProjectController extends Controller
{
    public function index()
    {
        $employees = Employee::orderBy('name')
            ->get();

        return view(
            'pages.project.index',
            compact('employees')
        );
    }

    public function list(Request $request)
    {
        $query = Project::query();

        if($request->year){

            $query->whereYear(
                'start_date',
                $request->year
            );
        }

        if($request->month){

            $query->whereMonth(
                'start_date',
                $request->month
            );
        }

        if($request->status){

            $query->where(
                'status',
                $request->status
            );
        }

        return DataTables::of($query)

            ->addIndexColumn()

            ->addColumn(
                'members_count',
                fn($row) =>
                    count(
                        $row->team_members ?? []
                    )
            )

            ->addColumn(
                'action',
                function($row){

                    return '
                        <button
                            class="btn btn-sm btn-primary viewBtn"
                            data-id="'.$row->id.'">
                            View
                        </button>

                        <button
                            class="btn btn-sm btn-warning editBtn"
                            data-id="'.$row->id.'">
                            Edit
                        </button>
                    ';
                }
            )
            ->addColumn('start_date', function ($row) {

                return $row->start_date
                    ? date('d-m-Y', strtotime($row->start_date))
                    : '-';

            })

            ->addColumn('end_date', function ($row) {

                return $row->end_date
                    ? date('d-m-Y', strtotime($row->end_date))
                    : '-';

            })
            ->filter(function ($query) use ($request) {

                if ($search = $request->search['value']) {

                    $query->where(function ($q) use ($search) {

                        $q->where('project_name', 'like', "%{$search}%");
                    
                    });
                }
            })
            

            ->rawColumns(['action'])

            ->make(true);
    }

    public function store(Request $request)
    {
        $teamMembers = [];

        foreach(
            $request->employee_id as $index => $employeeId
        ){

            $teamMembers[$employeeId] =
                $request->role[$index];

        }

        Project::updateOrCreate(

            [
                'id' => $request->id
            ],

            [
                'project_name' => $request->project_name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => $request->status,
                'description' => $request->description,
                'team_members' => $teamMembers
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'Project saved successfully'
        ]);
    }
    public function edit($id)
    {
        $project = Project::findOrFail($id);

        $project->start_date = date(
            'Y-m-d',
            strtotime($project->start_date)
        );

        $project->end_date = date(
            'Y-m-d',
            strtotime($project->end_date)
        );

        return response()->json($project);
    }
    public function storeOld(Request $request)
    {
        $request->validate([

            'project_name' => 'required',

            'start_date' => 'required',

            'end_date' => 'required',

            'status' => 'required'
        ]);

        $members = [];

        if($request->employee_id){

            foreach(
                $request->employee_id as $key => $employeeId
            ){

                $members[$employeeId] =
                    $request->role[$key];
            }
        }

        Project::create([

            'project_name' =>
                $request->project_name,

            'start_date' =>
                $request->start_date,

            'end_date' =>
                $request->end_date,

            'status' =>
                $request->status,

            'description' =>
                $request->description,

            'team_members' =>
                $members
        ]);

        return response()->json([

            'status' => true,

            'message' =>
                'Project added successfully'

        ]);
    }
    
    

    public function view($id)
    {
        $project = Project::findOrFail($id);

        $members = [];

        $slno = 1;

        foreach(
            ($project->team_members ?? [])
            as $employeeId => $role
        ){

            $employee = Employee::with([
                'department',
                'designation'
            ])->find($employeeId);

            if($employee){

                $members[] = [

                    'slno' => $slno++,

                    'employee_id' =>
                        $employee->emp_id,

                    'employee_name' =>
                        $employee->name,

                    'department' =>
                        $employee->department->name ?? '-',

                    'designation' =>
                        $employee->designation->name ?? '-',

                    'role' =>
                        $role
                ];
            }
        }

        return response()->json([

            'project' => $project,

            'members' => $members

        ]);
    }

  

    public function export(Request $request)
    {
        return Excel::download(
            new ProjectsExport($request),
            'Projects_Report.xlsx'
        );
    }
}
