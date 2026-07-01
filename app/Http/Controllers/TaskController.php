<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskUpdate;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TaskExport;
use App\Models\Department;
use App\Models\ScheduleCalendar;
use App\Models\Designation;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function allocation()
    {
        $employees=Employee::where("status","1")->orderBy('name')->get();
        $projects = Project::where("status","Active")
        ->where(function ($query) {
            $query->where('project_manager_id', auth()->id())
                  ->orWhere('team_head_id', auth()->id());
        })
        ->orderBy('project_name')->get();
        return view('pages.task.allocation',
        compact('projects','employees'));
    }

    public function projectModules($id)
    {
        $project = Project::findOrFail($id);
        $modules = [];
        foreach (($project->project_modules ?? []) as $moduleId => $moduleName) {
            $modules[] = [
                'id'   => $moduleId,
                'name' => $moduleName
            ];
        }
        return response()->json($modules);
    }
  
    public function list(Request $request)
    {
        if ($request->ajax()) {

            $tasks = Task::with([
                'project',
                'latestUpdate.employee',
                'latestUpdate.assignedBy'
            ])
            ->whereHas('project', function ($q) {
                $q->where(function ($sub) {
                    $sub->where('team_head_id', auth()->id())
                        ->orWhere('project_manager_id', auth()->id());
                });
            })
             ->when($request->project_id, function ($q) use ($request) {

                    $q->where('project_id', $request->project_id);

                })

                ->when($request->module_id, function ($q) use ($request) {

                    $q->where('module_id', $request->module_id);

                })

                ->when($request->priority, function ($q) use ($request) {

                    $q->whereHas('latestUpdate', function ($sub) use ($request) {

                        $sub->where('priority', $request->priority);

                    });

                })

                ->when($request->status, function ($q) use ($request) {

                    $q->whereHas('latestUpdate', function ($sub) use ($request) {

                        $sub->where('status', $request->status);

                    });

                })
            ->orderByDesc('id');

            return DataTables::of($tasks)

                ->addIndexColumn()

                ->addColumn('task_name', function ($row) {
                    return $row->latestUpdate->task_name ?? '-';
                })
                ->addColumn('project_name', function ($row) {

                    return optional($row->project)->project_name;

                })
                ->addColumn('module_name', function ($row) {

                    $modules = $row->project->project_modules ?? [];

                    return $modules[$row->module_id] ?? '-';
                })

                ->addColumn('assigned_to_name', function ($row) {

                    return optional(
                        $row->latestUpdate->employee
                    )->name ?? '-';
                })

                ->addColumn('assigned_by_name', function ($row) {

                    return optional(
                        $row->latestUpdate->assignedBy
                    )->name ?? '-';

                })

                ->addColumn('priority', function ($row) {

                    return $row->latestUpdate->priority ?? '-';
                })

                ->addColumn('start_date', function ($row) {

                    return $row->latestUpdate->start_date
                        ? date(
                            'd-m-Y',
                            strtotime(
                                $row->latestUpdate->start_date
                            )
                        )
                        : '-';
                })

                ->addColumn('end_date', function ($row) {

                    return $row->latestUpdate->end_date
                        ? date(
                            'd-m-Y',
                            strtotime(
                                $row->latestUpdate->end_date
                            )
                        )
                        : '-';
                })

                ->addColumn('status', function ($row) {

                    return $row->latestUpdate->status ?? '-';
                })

                ->addColumn('progress_bar', function ($row) {

                    $progress = $row->latestUpdate->progress ?? 0;

                    return '
                        <div>
                            <div class="mb-1 fw-bold">'.$progress.'%</div>

                            <div class="progress" style="height:6px;">
                                <div class="progress-bar"
                                    role="progressbar"
                                    style="width: '.$progress.'%;"
                                    aria-valuenow="'.$progress.'"
                                    aria-valuemin="0"
                                    aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    ';
                })

                ->addColumn('action', function ($row) {

                    return '
                        <button
                            class="btn btn-sm btn-info viewBtn"
                            data-id="'.$row->id.'">
                            View
                        </button>

                        <button
                            class="btn btn-sm btn-primary editBtn"
                            data-id="'.$row->id.'">
                            Edit
                        </button>

                        <button
                            class="btn btn-sm btn-danger deleteBtn"
                            data-id="'.$row->id.'">
                            Delete
                        </button>
                    ';
                })

                ->rawColumns([
                    'progress_bar',
                    'action'
                ])

                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $request->validate([

            'project_id'       => 'required',
            'module_id'        => 'required',
            'task_name'        => 'required|string|max:255',
            'assigned_to'      => 'required',
            'start_date'       => 'required|date',
            'end_date'         => 'required|date',
            'priority'         => 'required',
            'estimated_hours'  => 'required|numeric|min:0',

            'attachment'       => 'nullable|file'
        ]);

        DB::beginTransaction();

        try {

            $task = Task::create([

                'task_code'  => 'TSK' . str_pad(
                    (Task::withTrashed()->max('id') ?? 0) + 1,
                    5,
                    '0',
                    STR_PAD_LEFT
                ),

                'project_id' => $request->project_id,

                'module_id'  => $request->module_id
            ]);

            $attachment = null;

            if ($request->hasFile('attachment')) {

                $file = $request->file('attachment');

                $fileName =
                    time().
                    rand(10,99).
                    '_'.
                    $task->id.
                    '.'.
                    $file->getClientOriginalExtension();

                $file->storeAs(
                    'tasks',
                    $fileName,
                    'public'
                );

                $attachment = $fileName;
            }

            TaskUpdate::create([

                'task_id'         => $task->id,

                'task_name'       => $request->task_name,

                'employee_id'     => $request->assigned_to,
                'assigned_by'     => auth()->id(),
                'priority'        => $request->priority,

                'start_date'      => $request->start_date,

                'end_date'        => $request->end_date,

                'status'          => 'Pending',

                'progress'        => 0,

                'hours_worked'    => 0,

                'remaining_hours' => $request->estimated_hours,

                'dependencies'    => $request->dependencies,

                'work_summary'    => null,

                'attachment' => $attachment,


            ]);

            DB::commit();

            return response()->json([

                'status'  => true,

                'message' => 'Task created successfully'

            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([

                'status'  => false,

                'message' => $e->getMessage()

            ],500);
        }
    }

    public function projectTeamMembers($projectId)
    {
        $project = Project::findOrFail($projectId);

        $employeeIds = array_keys(
            $project->team_members ?? []
        );

        $employees = Employee::whereIn(
            'id',
            $employeeIds
        )
        ->select('id', 'name')
        ->get();

        return response()->json($employees);
    }

    public function saveTaskUpdate(Request $request)
    {
        $request->validate([
            'task_id'         => 'required|exists:tasks,id',
            'status'          => 'required',
            'progress'        => 'required|numeric|min:0|max:100',
            'hours_worked'    => 'required|numeric|min:0',
            'remaining_hours' => 'nullable|numeric|min:0',
            'challenge'       => 'nullable|string',
            'work_summary'    => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {

            $lastUpdate = TaskUpdate::where('task_id', $request->task_id)
                            ->latest()
                            ->first();
            $update = new TaskUpdate();

            $update->task_id = $request->task_id;
            $update->task_name = $lastUpdate->task_name;
            $update->employee_id = auth()->id(); 
            $update->assigned_by = $lastUpdate->assigned_by;
            $update->priority = $lastUpdate->priority;
            $update->start_date = $lastUpdate->start_date;
            $update->end_date = $lastUpdate->end_date;
            $update->attachment = $lastUpdate->attachment;

            $update->status = $request->status;
            $update->progress = $request->progress;
            $update->hours_worked = $request->hours_worked;
            $update->remaining_hours = $request->remaining_hours;
            $update->dependencies = $request->challenge;
            $update->work_summary = $request->work_summary;

            // $update->created_by = auth()->id();

            $update->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Task updated successfully.'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    
    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $task = Task::find($id);

            if (!$task) {
                return response()->json([
                    'status' => false,
                    'message' => 'Task not found.'
                ]);
            }

            $updates = TaskUpdate::where('task_id', $id)->get();

            if (
                $updates->count() == 1 &&
                strtolower($updates->first()->status) == 'pending' && $updates->first()->progrss ==0  
            ) {

                TaskUpdate::where('task_id', $id)->delete();

                $task->delete();

                DB::commit();

                return response()->json([
                    'status' => true,
                    'message' => 'Task deleted successfully.'
                ]);
            }

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Task cannot be deleted because it has already been updated.'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);

        }
    }

    public function myTask()
    {
        $employeeId = Auth::id();
 
        $latestTaskIds = TaskUpdate::selectRaw('MAX(id) as id')
            ->where('employee_id', $employeeId)
            ->groupBy('task_id')
            ->pluck('id');

        $latestTasks = TaskUpdate::whereIn('id', $latestTaskIds);

        $totalTasks = (clone $latestTasks)->count();

        $inProgressTasks = (clone $latestTasks)
            ->where('status', 'In Progress')
            ->whereDate('end_date', '>', now()->toDateString())
            ->count();

        $pendingTasks = (clone $latestTasks)
            ->Where('status', 'Pending')
            ->whereDate('end_date', '>', now()->toDateString())
            ->count();

        $completedTasks = (clone $latestTasks)
            ->where('status', 'Completed')
            ->count();

        $overdueTasks = (clone $latestTasks)
            ->where('status', '!=', 'Completed')
            ->whereDate('end_date', '<', now()->toDateString())
            ->count();
        // Projects assigned to logged in employee

        $projectIds = Project::whereRaw(
            "JSON_CONTAINS_PATH(team_members, 'one', ?)",
            ['$."' . $employeeId . '"']
        )->pluck('id');
        $projects = Project::whereIn('id', $projectIds)
        ->where("status","Active")
        ->orderBy('project_name')
        ->get();
        return view(
            'pages.task.mytask',
            compact(
                'totalTasks',
                'inProgressTasks',
                'pendingTasks',
                'completedTasks',
                'overdueTasks',
                'projects'
            )
        );
    }

    public function myTaskList(Request $request)
    {
        if ($request->ajax()) {

            $tasks = Task::with([
                    'project',
                    'latestUpdate'
                ])

                ->whereHas('latestUpdate', function ($q) {

                    $q->where('employee_id', auth()->id());

                })

                ->when($request->project_id, function ($q) use ($request) {

                    $q->where('project_id', $request->project_id);

                })

                ->when($request->module_id, function ($q) use ($request) {

                    $q->where('module_id', $request->module_id);

                })

                ->when($request->priority, function ($q) use ($request) {

                    $q->whereHas('latestUpdate', function ($sub) use ($request) {

                        $sub->where('priority', $request->priority);

                    });

                })

                ->when($request->status, function ($q) use ($request) {

                    $q->whereHas('latestUpdate', function ($sub) use ($request) {

                        $sub->where('status', $request->status);

                    });

                })
                ->when($request->search['value'] ?? null, function ($q) use ($request) {

                    $search = $request->search['value'];

                    $q->where(function ($query) use ($search) {

                        $query->where('task_code', 'like', "%{$search}%")

                            ->orWhereHas('latestUpdate', function ($sub) use ($search) {

                                $sub->where('task_name', 'like', "%{$search}%");

                            });

                    });

                })

                ->latest();
            return DataTables::of($tasks)

                ->addIndexColumn()

                ->addColumn('task_code', function ($row) {

                    return $row->task_code;

                })

                ->addColumn('task_name', function ($row) {

                    return optional($row->latestUpdate)->task_name;

                })

                ->addColumn('project_name', function ($row) {

                    return optional($row->project)->project_name;

                })

                ->addColumn('module_name', function ($row) {

                    $modules = $row->project->project_modules ?? [];

                    return $modules[$row->module_id] ?? '-';

                })

                ->addColumn('priority', function ($row) {

                    return optional($row->latestUpdate)->priority;

                })

                ->addColumn('start_date', function ($row) {

                    return optional($row->latestUpdate)->start_date
                        ? date('d-m-Y', strtotime($row->latestUpdate->start_date))
                        : '-';

                })

                ->addColumn('end_date', function ($row) {

                    return optional($row->latestUpdate)->end_date
                        ? date('d-m-Y', strtotime($row->latestUpdate->end_date))
                        : '-';

                })
                ->addColumn('remaining_hours', function ($row) {

                    return optional($row->latestUpdate)->remaining_hours;

                })

                ->addColumn('status', function ($row) {

                    return optional($row->latestUpdate)->status;

                })

               ->addColumn('progress', function ($row) {

                    $progress = optional($row->latestUpdate)->progress ?? 0;

                    $color = 'bg-primary';

                    if ($progress >= 100) {
                        $color = 'bg-success';
                    } elseif ($progress >= 75) {
                        $color = 'bg-info';
                    } elseif ($progress >= 50) {
                        $color = 'bg-warning';
                    } elseif ($progress >= 25) {
                        $color = 'bg-secondary';
                    }

                    return '
                        <div>
                            <div class="mb-1 fw-bold">'.$progress.'%</div>

                            <div class="progress" style="height:6px;">
                                <div class="progress-bar"
                                    role="progressbar"
                                    style="width: '.$progress.'%;"
                                    aria-valuenow="'.$progress.'"
                                    aria-valuemin="0"
                                    aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    ';

                })

                ->addColumn('action', function ($row) {

                    return '
                        <button
                            class="btn btn-sm btn-info viewBtn"
                            data-id="'.$row->id.'">
                            View
                        </button>
                    ';

                })

                ->rawColumns([
                    'progress',
                    'action'
                ])

                ->make(true);
        }
    }

    public function viewMyTask($id)
    {
        $task = Task::with('project')->findOrFail($id);
        $firstUpdate = TaskUpdate::where('task_id',$id)
                ->oldest()
                ->first();
        $latest = TaskUpdate::with([
                'employee',
                'assignedBy'
            ])
            ->where('task_id',$id)
            ->latest()
            ->first();

        $modules = $task->project->project_modules ?? [];

        $history = TaskUpdate::with('employee')
            ->where('task_id', $id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($row) {

                return [

                    'status' => $row->status,
                    'progress' => $row->progress,
                    'hours_worked' => $row->hours_worked,
                    'remaining_hours' => $row->remaining_hours,
                    'challenge' => $row->challenge,
                    'work_summary' => $row->work_summary,
                    'employee_name' => optional($row->employee)->name,
                    'created_at' => $row->created_at->format('d-m-Y h:i A'),

                ];

            });

        return response()->json([

            'status'=>true,

            'task'=>[

                'id'=>$latest->task_id,
                'project_name'=>$task->project->project_name,

                'module_name'=>$modules[$task->module_id] ?? '-',

                'task_name'=>$latest->task_name,

                'assigned_to'=>optional($latest->employee)->name,

                'assigned_by'=>optional($latest->assignedBy)->name,

                'start_date'=>date('d-m-Y',strtotime($latest->start_date)),

                'end_date'=>date('d-m-Y',strtotime($latest->end_date)),

                'priority'=>$latest->priority,
                'status'           => $latest->status,
                'progress'         => $latest->progress,
                'hours_worked'     => $latest->hours_worked,
                'challenge'        => $latest->challenge,
                'work_summary'     => $latest->work_summary,
                // Estimated Hours = first task_update remaining_hours
                'estimated_hours' => $firstUpdate->remaining_hours ?? 0,

                // Remaining Hours = latest task_update remaining_hours
                'remaining_hours' => $latest->remaining_hours ?? 0,

                'dependencies'=>$latest->dependencies,

                'attachment'=>$latest->attachment
                    ? asset('storage/tasks/'.$latest->attachment)
                    : null,

            ],

            'history'=>$history

        ]);
    }

    public function export(Request $request)
    {
        return Excel::download(
            new TaskExport($request),
            'Tasks_'.date('Ymd_His').'.xlsx'
        );
    }

    public function utilization()
    {
        $departments = Department::where('status', 'active')->get();
        $employees = Employee::where('status',1)->count();

        $fully = 0;
        $partial = 0;
        $bench = 0;
        $under = 0;
        $employees=Employee::where("status","1")->orderBy('name')->get();
        $projects = Project::where("status","Active")
        ->where(function ($query) {
            $query->where('project_manager_id', auth()->id())
                  ->orWhere('team_head_id', auth()->id());
        })
        ->orderBy('project_name')->get();
        return view('pages.task.resource-utilization',
        compact('projects','employees','departments'));
    }

   
    
    public function utilizationList(Request $request)
    {
        $year  = $request->year ?? date('Y');
        $month = $request->month ?? date('m');
        
        /*
        |--------------------------------------------------------------------------
        | Employees
        |--------------------------------------------------------------------------
        */

        
        $employees = Employee::select(
            'id',
            'name',
            'department_id'
        )
        ->with('department:id,name')
        ->where('status',1)

        ->when($request->filter_department,function($q) use($request){

            $q->where(
                'department_id',
                $request->filter_department
            );

        })

        ->orderBy('name')
        ->get();

        /*
        |--------------------------------------------------------------------------
        | Active Projects
        |--------------------------------------------------------------------------
        */

        $projects = Project::select(
                'id',
                'project_name',
                'team_members',
                'status'
            )
            ->where('status', 'Active')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Schedule Calendars
        |--------------------------------------------------------------------------
        */

        $calendars = ScheduleCalendar::where('year', $year)
            ->get()
            ->keyBy('project_id');

        /*
        |--------------------------------------------------------------------------
        | Allocation Query (One SQL Only)
        |--------------------------------------------------------------------------
        */
        $from = Carbon::create($year, $month, 1)->startOfMonth()->toDateString();
        $to  = Carbon::create($year, $month, 1)->endOfMonth()->toDateString();
        $allocations = DB::table('tasks')
        
        ->join(DB::raw("
            (
                SELECT tu1.*
                FROM task_updates tu1
                INNER JOIN
                (
                    SELECT task_id,MIN(id) first_id
                    FROM task_updates
                    GROUP BY task_id
                ) x
                ON x.first_id=tu1.id
            ) first_update
        "),function($join){

            $join->on(
                'tasks.id',
                '=',
                'first_update.task_id'
            );

        })

        ->where(function ($q) use ($from, $to) {

            $q->whereBetween('first_update.start_date', [$from, $to])

            ->orWhereBetween('first_update.end_date', [$from, $to])

            ->orWhere(function ($qq) use ($from, $to) {

                    $qq->where('first_update.start_date', '<=', $from)
                    ->where('first_update.end_date', '>=', $to);

            });

        })

        ->select(
            'tasks.project_id',
            'first_update.employee_id',
            DB::raw('SUM(first_update.remaining_hours) total_hours')
        )

        ->groupBy(
            'tasks.project_id',
            'first_update.employee_id'
        )

        ->get();

        /*
        |--------------------------------------------------------------------------
        | Allocation Map
        |--------------------------------------------------------------------------
        */

        $allocationMap = [];

        foreach ($allocations as $row) {

            $allocationMap[$row->employee_id][$row->project_id]
                = $row->total_hours;

        }

        /*
        |--------------------------------------------------------------------------
        | Holiday Count Map
        |--------------------------------------------------------------------------
        */

        $holidayMap = [];

        foreach ($calendars as $projectId => $calendar) {

            $holidayMap[$projectId] = collect($calendar->holidays ?? [])
                ->filter(function ($holiday) use ($year, $month) {

                    return date('Y', strtotime($holiday['date'])) == $year
                        && date('n', strtotime($holiday['date'])) == $month;

                })
                ->count();

        }

        /*
        |--------------------------------------------------------------------------
        | Month Capacity
        |--------------------------------------------------------------------------
        */

        $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;

        $data = [];

        foreach ($employees as $employee) {

            $employeeProjects = $projects->filter(function ($project) use ($employee) {

                return is_array($project->team_members)
                    && isset($project->team_members[$employee->id]);

            });

            $currentAllocation = [];

            $totalAllocatedHours = 0;

            $maxHours = 0;

            foreach ($employeeProjects as $project) {

                $holidayCount = $holidayMap[$project->id] ?? 0;

                $workingDays = $daysInMonth - $holidayCount;

                $projectCapacity = $workingDays * 8;

                $maxHours = max($maxHours, $projectCapacity);

                $hours = $allocationMap[$employee->id][$project->id] ?? 0;

                $totalAllocatedHours += $hours;

                $allocation = $projectCapacity > 0
                    ? round(($hours / $projectCapacity) * 100, 2)
                    : 0;

                $currentAllocation[] =
                    $project->project_name .
                    ' (' . $allocation . '%)';
            }

            $totalAllocation = $maxHours > 0
                ? round(($totalAllocatedHours / $maxHours) * 100, 2)
                : 0;

            $balance = max(0, 100 - $totalAllocation);

            if ($totalAllocation == 0) {

                $status = 'Available / Bench';
                $badge = 'danger';

            } elseif ($totalAllocation <= 39) {

                $status = 'Under Utilized';
                $badge = 'warning';

            } elseif ($totalAllocation <= 69) {

                $status = 'Partially Utilized';
                $badge = 'secondary';

            } elseif ($totalAllocation <= 89) {

                $status = 'Optimally Utilized';
                $badge = 'success';

            } elseif ($totalAllocation <= 100) {

                $status = 'Fully Utilized';
                $badge = 'primary';

            } else {

                $status = 'Over Allocated';
                $badge = 'dark';

            }

            $data[] = [

                'employee' => $employee->name,

                'department' => $employee->department->name ?? '-',

                'current_allocation' => implode('<br>', $currentAllocation),

                'total_allocation' => number_format($totalAllocation, 2) . '%',

                'balance' => number_format($balance, 2) . '%',

                'status' => '<span class="badge bg-' . $badge . '">' . $status . '</span>'

            ];
        }

        return DataTables::of(collect($data))
            ->addIndexColumn()
            ->rawColumns([
                'current_allocation',
                'status'
            ])
            ->make(true);
    }

    
}