<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Project;
use App\Models\ScheduleCalendar;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CalendarController extends Controller
{
    public function schedule()
    {
        $projects = Project::all();

        $calendars = ScheduleCalendar::with('project')
            ->latest()
            ->get();

        return view(
            'pages.attendance.schedule',
            compact(
                'projects',
                'calendars'
            )
        );
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {

            $query = ScheduleCalendar::with('project')
                ->select('schedule_calendars.*');

            return DataTables::of($query)

                ->addIndexColumn()

                ->addColumn('project_name', function ($row) {

                    return $row->project->project_name ?? '-';
                })

                ->addColumn('action', function ($row) {

                    return '
                        <button
                            class="btn btn-sm btn-info viewBtn"
                            data-id="' . $row->id . '">
                            View
                        </button>
                        <button class="btn btn-warning btn-sm editBtn"
                            data-id="' . $row->id . '">
                            Edit
                        </button>

                        <button class="btn btn-danger btn-sm deleteBtn"
                            data-id="' . $row->id . '">
                            Delete
                        </button>
                    ';
                })

                ->rawColumns(['action'])

                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'project_id' => 'required|exists:projects,id',
            'holiday_date' => 'required|array|min:1',
            'holiday_date.*' => 'required|date',
            'description' => 'required|array|min:1',
            'description.*' => 'required|string|max:255',
        ]);

        $holidays = [];

        foreach ($request->holiday_date as $key => $date) {

            if (date('Y', strtotime($date)) != $request->year) {

                return response()->json([
                    'status' => false,
                    'message' => 'All holiday dates must belong to selected year.'
                ], 422);
            }

            $holidays[] = [
                'date' => $date,
                'description' => $request->description[$key]
            ];
        }

        // UPDATE
        if (!empty($request->holiday_id)) {

            $calendar = ScheduleCalendar::findOrFail(
                $request->holiday_id
            );
            $exists = ScheduleCalendar::where('year', $request->year)
                ->where('project_id', $request->project_id)
                ->where('id', '!=', $request->holiday_id)->exists();
            if ($exists) {
                return response()->json([
                    'status' => false,
                    'message' => 'Holiday calendar already exists for selected project and year.'
                ], 422);
            }
            $calendar->update([
                'year' => $request->year,
                'project_id' => $request->project_id,
                'holidays' => $holidays
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Holiday calendar updated successfully.'
            ]);
        }

        // CREATE
        $exists = ScheduleCalendar::where(
            'year',
            $request->year
        )
            ->where(
                'project_id',
                $request->project_id
            )
            ->exists();

        if ($exists) {

            return response()->json([
                'status' => false,
                'message' => 'Holiday calendar already exists for selected project and year.'
            ], 422);
        }

        ScheduleCalendar::create([
            'year' => $request->year,
            'project_id' => $request->project_id,
            'holidays' => $holidays
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Holiday calendar created successfully.'
        ]);
    }
    public function storeOld(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'project_id' => 'required|exists:projects,id',
            'holiday_date' => 'required|array|min:1',
            'holiday_date.*' => 'required|date',
            'description' => 'required|array|min:1',
            'description.*' => 'required|string|max:255',
        ]);

        $holidays = [];

        foreach ($request->holiday_date as $key => $date) {

            // Validate selected year
            if (date('Y', strtotime($date)) != $request->year) {

                return response()->json([
                    'status' => false,
                    'message' => 'All holiday dates must belong to selected year.'
                ], 422);
            }

            $holidays[] = [
                'date' => $date,
                'description' => $request->description[$key]
            ];
        }

        $calendar = ScheduleCalendar::where('year', $request->year)
            ->where('project_id', $request->project_id)
            ->first();

        if ($calendar) {

            $calendar->update([
                'year' => $request->year,
                'project_id' => $request->project_id,
                'holidays' => $holidays
            ]);
        } else {

            ScheduleCalendar::create([
                'year' => $request->year,
                'project_id' => $request->project_id,
                'holidays' => $holidays
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Holiday calendar saved successfully.'
        ]);
    }

    public function show($id)
    {
        $calendar = ScheduleCalendar::with('project')
            ->findOrFail($id);

        $teamMembers = $calendar->project->team_members ?? [];

        $employeeIds = array_keys($teamMembers);

        $employees = Employee::with([
            'department',
            'designation'
        ])
            ->whereIn('id', $employeeIds)
            ->get();

        return response()->json([
            'status' => true,
            'data' => $calendar,
            'employees' => $employees,
            'roles' => $teamMembers
        ]);
    }

    public function edit($id)
    {
        $calendar = ScheduleCalendar::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $calendar
        ]);
    }



    public function destroy($id)
    {
        ScheduleCalendar::findOrFail($id)
            ->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted successfully'
        ]);
    }
}
