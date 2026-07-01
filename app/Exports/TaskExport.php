<?php

namespace App\Exports;

use App\Models\Task;
use App\Models\TaskUpdate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TaskExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        return Task::with([
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

        ->when($this->request->project_id, fn($q) =>
            $q->where('project_id', $this->request->project_id))

        ->when($this->request->module_id, fn($q) =>
            $q->where('module_id', $this->request->module_id))

        ->when($this->request->priority, function ($q) {
            $q->whereHas('latestUpdate', function ($s) {
                $s->where('priority', $this->request->priority);
            });
        })

        ->when($this->request->status, function ($q) {
            $q->whereHas('latestUpdate', function ($s) {
                $s->where('status', $this->request->status);
            });
        })

        ->get()

        ->map(function ($task) {

            $modules = $task->project->project_modules ?? [];

            return [

                'Task Name'     => $task->latestUpdate->task_name ?? '',
                'Project'       => optional($task->project)->project_name,
                'Module'        => $modules[$task->module_id] ?? '',
                'Assigned To'   => optional($task->latestUpdate->employee)->name,
                'Assigned By'   => optional($task->latestUpdate->assignedBy)->name,
                'Priority'      => $task->latestUpdate->priority,
                'Start Date'    => $task->latestUpdate->start_date,
                'End Date'      => $task->latestUpdate->end_date,
                'Status'        => $task->latestUpdate->status,
                'Progress (%)'  => $task->latestUpdate->progress,

            ];

        });
    }

    public function headings(): array
    {
        return [
            'Task Name',
            'Project',
            'Module',
            'Assigned To',
            'Assigned By',
            'Priority',
            'Start Date',
            'End Date',
            'Status',
            'Progress (%)'
        ];
    }
}