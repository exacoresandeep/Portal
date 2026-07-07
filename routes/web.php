<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AssetRequestController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\EmployeeOffboardController;
use App\Http\Controllers\TrainingPhaseController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;

// Handle login
Route::get('/', function () { return view('auth.login'); })->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/login', function () {

    if (Auth::check()) {
        $employees = Employee::where('status', 1)->get();
            return view('dashboard', $employees);
        
    }

    return view('auth.login');

})->name('getlogin');
// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// Dashboard (protected)
Route::get('/dashboard/attendance', [LoginController::class, 'attendanceData'])
    ->middleware('auth')
    ->name('dashboard.attendance');
Route::get('/dashboard', [LoginController::class, 'dashboardContent'])->name('dashboard')->middleware('auth')->middleware('department.access:dashboard');
// Route::view('/dashboard-content', 'pages.dashboard-content')->middleware('auth')->name('dashboard.content');
Route::get('/dashboard-content', [LoginController::class, 'dashboardContent'])->middleware('auth')->name('dashboard.content');
Route::get('/employees',[EmployeeController::class, 'index'])->name('employees.index')->middleware('department.access:employees');
Route::get('/employee-list',[EmployeeController::class, 'employeeList'])->name('employees.list');
Route::get('/employees/export',[EmployeeController::class, 'exportEmployees'])->name('employees.export');
Route::post('/employee/reset-password/{id}', [EmployeeController::class, 'resetPassword'])->name('employee.resetPassword');
Route::get('/employee-directory',[EmployeeController::class, 'employeeDirectory'])->name('employeedirectory.index');
Route::get('/employeeOnboard-list',[EmployeeController::class, 'employeeOnboardList'])->name('onboard.list');
Route::get('/onboard/export', [EmployeeController::class, 'onboardExport'])->name('onboard.export');
Route::get('/employee/details/{id}', [EmployeeController::class, 'employeeDetails'])->name('employee.details');
Route::post('/employee/store', [EmployeeController::class, 'store'])->name('employee.store');
Route::post('/employee/delete/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');
Route::post('/employee/change-password/{id}', [EmployeeController::class, 'changePassword'])->name('employee.changePassword');
Route::post('/employee/update/{id}', [EmployeeController::class, 'update'])->name('employee.update');
Route::post('/employee/update-photo',[EmployeeController::class,'updatePhoto'])->name('employee.update.photo');
Route::post('/employee/verify/{id}', [EmployeeController::class, 'verifyEmployee'])->name('employee.verify');
Route::get('/employee/edit/{id}',[EmployeeController::class,'edit']);
Route::post('/employee/update-profile',[EmployeeController::class,'updateProfile'])->name("employee.updateProfile");
Route::post('/employee/update-official',[EmployeeController::class,'updateOfficial']);
Route::post('/employee/update-bank',[EmployeeController::class,'updateBank']);
Route::post('/employee/update-education',[EmployeeController::class,'updateEducation']);
Route::post('/employee/update-experience',[EmployeeController::class,'updateExperience']);
Route::post('/employee/update-document',[EmployeeController::class,'updateDocument']);

Route::get('/employees/edit/{id}', [EmployeeController::class, 'edit'])->name('employees.edit');
Route::delete('/employees/delete/{id}', [EmployeeController::class, 'destroy'])->name('employees.delete');
Route::get('/employees-by-department',[EmployeeController::class,'employeesByDepartment'])->name('employees.department');

Route::prefix('attendance')->group(function () {

    Route::get('/capture', [AttendanceController::class, 'capture'])->name('attendance.capture');
    Route::get('/captureList', [AttendanceController::class, 'captureList'])->name('attendance.captureList');
    Route::get('/attendancecaptureExport', [AttendanceController::class, 'captureExport'])->name('attendancecapture.export');
    
    
        
    Route::get('/tracking', [AttendanceController::class, 'tracking'])->name('attendance.tracking');
    Route::get('attendance-tracking-list',[AttendanceController::class, 'trackingList'])->name('attendance.tracking.list');
    Route::get('attendance-tracking-export',[AttendanceController::class, 'trackingExport'])->name('attendance.tracking.export');
    
    Route::get('/regularization', [AttendanceController::class, 'regularization'])
    ->name('attendance.regularization');
    Route::get('/regularizationList', [AttendanceController::class, 'regularizationList'])->name('attendance.regularization.list');
    Route::get('attendance-regularization-export',[AttendanceController::class, 'regularizationExport'])->name('attendance.regularization.export');
    Route::get('regularization/{id}',[AttendanceController::class,'getRegularization']);
    Route::post(
        'regularization/approve',
        [AttendanceController::class, 'approveRegularization']
    )->name('regularization.approve');

    Route::post(
        'regularization/reject/{id}',
        [AttendanceController::class, 'rejectRegularization'])->name('regularization.reject');
    
    
    Route::get('/summary', [AttendanceController::class, 'summary'])->name('attendance.summary');
    Route::get('/summaryList', [AttendanceController::class, 'summaryList'])->name('attendance.summary.list');
    Route::get('attendance-summary-export',[AttendanceController::class, 'summaryExport'])->name('attendance.summaryExport');
    Route::get('punch-details/{employee}/{date}',[AttendanceController::class, 'punchDetails'])->name('attendance.punch.details');
    Route::get('/reports', [AttendanceController::class, 'reports'])
        ->name('attendance.reports');

});

Route::get('/schedule', [CalendarController::class, 'schedule'])->name('calender.schedule');
Route::get('/calendar/list', [CalendarController::class, 'list'])->name('calendar.list');
Route::get('/calendar/{id}',[CalendarController::class,'show'])->name('calendar.show');
Route::post('/calendar/store',[CalendarController::class,'store'])->name('calendar.store');
Route::get('/calendar/edit/{id}',[CalendarController::class,'edit']);
Route::post('/calendar/update/{id}',[CalendarController::class,'update']);
Route::delete('/calendar/delete/{id}',[CalendarController::class,'destroy']);

Route::get('/leave-requests', [LeaveController::class, 'index'])->name('leave.index');
Route::get('/leave-requests/list', [LeaveController::class, 'leaveList'])->name('leave.list');

Route::post('/leave-requests/{id}/approve', [LeaveController::class, 'approve'])->name('leave.approve');
Route::post('/leave-requests/{id}/reject', [LeaveController::class, 'reject'])->name('leave.reject');
Route::get('/leave-requests-export', [LeaveController::class, 'exportLeaveRequests'])->name('leave.export');

Route::get('/wfh-requests', [LeaveController::class, 'wfh'])->name('wfh.index');
Route::get('/wfh-requests/list', [LeaveController::class, 'wfhList'])->name('wfh.list');

Route::post('/wfh-requests/{id}/approve', [LeaveController::class, 'wfhApprove'])->name('wfh.approve');
Route::post('/wfh-requests/{id}/reject', [LeaveController::class, 'wfhReject'])->name('wfh.reject');
Route::get('/wfh-requests-export',[LeaveController::class, 'exportWfhRequests'])->name('wfh.export');

Route::get('/leavecount', [LeaveController::class, 'leavecount'])->name('leavecount.index');
Route::get('/leavecount/list', [LeaveController::class, 'leavecountList'])->name('leavecount.list');
Route::get('/leave-count/export',[LeaveController::class, 'exportLeaveCounts'])->name('leavecount.export');


Route::get('/assets-requests', [AssetRequestController::class, 'requests'])->name('assets.requests');
Route::get('/assets-requests/list', [AssetRequestController::class, 'requestsList'])->name('assets-requests.list');
Route::get('/assets-requests/export',[AssetRequestController::class, 'exportAssetRequests'])->name('asset-request.export');
Route::post('/asset-requests/store',[AssetRequestController::class,'store'])->name('asset-request.store');
Route::post('/asset-request/delete', [AssetRequestController::class, 'delete'])->name('asset-request.delete');

Route::get('/assets-assigned', [AssetRequestController::class, 'assigned'])->name('assets.assigned');
Route::get('/assets-assigned/list', [AssetRequestController::class, 'assignedList'])->name('assigned-assets.list');
Route::get('/asset-details/{id}',[AssetRequestController::class,'assetDetails'])->name('asset.details');
Route::post('/assets-assigned/store', [AssetRequestController::class, 'assign'])->name('assets.assign');
Route::post('/assigned-assets/return', [AssetRequestController::class, 'returnAsset'])->name('assigned-assets.return');
Route::post('/assigned-assets/transfer',[AssetRequestController::class,'transferAsset'])->name('assigned-assets.transfer');
Route::get('/assigned-assets-export',[AssetRequestController::class,'export'])->name('assigned-assets.export');

Route::get('/expenses', [ExpenseController::class, 'index'])->name('expense.index');
Route::get('/expenses/list',[ExpenseController::class,'list'])->name('expenses.list');
Route::post('/expense/status',[ExpenseController::class,'changeStatus'])->name('expense.status');


Route::get('/evaluation-forms',[EvaluationController::class,'index'])->name('evaluation.forms');
Route::get('/evaluation-forms/list',[EvaluationController::class,'list'])->name('evaluation.forms.list');
Route::post('/evaluation-forms/delete',[EvaluationController::class,'delete'])->name('evaluation.forms.delete');
Route::post('/evaluation-form/store',[EvaluationController::class,'store'])->name('evaluation.forms.store');
Route::get('/evaluation-form/view/{id}',[EvaluationController::class,'view'])->name('evaluation.form.view');
Route::get('/evaluation-form/edit/{id}',[EvaluationController::class,'edit'])->name('evaluation.form.edit');

Route::get('/evaluation-form/{id}',[EvaluationController::class,'getForm'])->name('evaluation.forms.get');
Route::get('/evaluation-form-view/{id}',[EvaluationController::class,'viewForm'])->name('evaluation.forms.view');


Route::get('/evaluation-scheduling',[EvaluationController::class,'scheduling'])->name('evaluation.scheduling');
Route::get('/evaluation-scheduling/list',[EvaluationController::class,'scheduleList'])->name('evaluation.schedule.list');
Route::post('/evaluation-assign-store',[EvaluationController::class, 'assignEvaluationForm'])->name('evaluation.assign.store');
Route::get('/evaluation-schedule-view/{id}',[EvaluationController::class,'scheduleView'])->name('evaluation.schedule.view');
Route::delete('/evaluation-schedule-delete/{id}',[EvaluationController::class, 'deleteSchedule'])->name('evaluation.schedule.delete');


Route::get('/evaluation-report',[EvaluationController::class,'report'])->name('evaluation.report');
Route::get('/evaluation-report-list',[EvaluationController::class, 'evaluationReportList'])->name('evaluation.report.list');
Route::get('/evaluation-report-view/{id}',[EvaluationController::class, 'evaluationReportView'])->name('evaluation.report.view');
Route::get('/evaluation-report-export',[EvaluationController::class,'exportReport'])->name('evaluation.report.export');
Route::post('/evaluation-report-review',[EvaluationController::class, 'saveEvaluationReview'])->name('evaluation.report.review');
Route::get('/evaluation-pip',[EvaluationController::class,'pip'])->name('evaluation.pip');
Route::get('/pip-list', [EvaluationController::class, 'pipList'])->name('pip.list');

Route::get('/project-management',[ProjectController::class,'index'])->name('project.index');
Route::get('/project-list',[ProjectController::class,'list'])->name('project.list');
Route::post('/project-store',[ProjectController::class,'store'])->name('project.store');
Route::get('/project-view/{id}',[ProjectController::class,'view'])->name('project.view');
Route::get('/project-edit/{id}',[ProjectController::class,'edit'])->name('project.edit');
Route::post('/project-update/{id}',[ProjectController::class,'update'])->name('project.update');
Route::delete('/project/delete/{id}',[ProjectController::class, 'delete'])->name('project.delete');
Route::get('/project-export',[ProjectController::class,'export'])->name('project.export');

Route::prefix('offboard')->group(function () {
    
    Route::get('/offboard.export',[EmployeeOffboardController::class,'export'])->name('offboard.export');
    Route::get('/', [EmployeeOffboardController::class,'index'])->name('offboard.index');
    Route::get('/list', [EmployeeOffboardController::class,'list'])->name('offboard.list');
    Route::post('/add', [EmployeeOffboardController::class,'add'])->name('offboard.add');
    Route::post('/store', [EmployeeOffboardController::class,'store'])->name('offboard.store');
    Route::get('/view/{id}', [EmployeeOffboardController::class,'view'])->name('offboard.view');
    Route::post('/hr-process-update',[EmployeeOffboardController::class, 'updateHrProcess'])->name('offboard.hr-process-update');
    // Route::post('/update/{id}', [EmployeeOffboardController::class,'update'])->name('offboard.update');
});

Route::get('active-employees', [EmployeeController::class, 'getActiveEmployees'])->name('active.employees');

Route::get('/training-phases',[TrainingPhaseController::class, 'index'])->name('training.phase.index');
Route::get('/training-phase/view/{id}',[TrainingPhaseController::class,'view'])->name('training.phase.view');
Route::get('/training-phase/edit/{id}',[TrainingPhaseController::class,'edit'])->name('training.phase.edit');
Route::post('/training-phase/update/{id}',[TrainingPhaseController::class,'update'])->name('training.phase.update');
Route::post('/training-phases/store',[TrainingPhaseController::class, 'store'])->name('training.phase.store');
Route::get('/training-phases/list',[TrainingPhaseController::class, 'list'])->name('training.phase.list');

Route::get('/traineemangement',[TrainingPhaseController::class, 'traineemangement'])->name('training.assign.index');
Route::post('/training/assign', [TrainingPhaseController::class, 'assign'])->name('training.assign');
Route::get('/training/assign-list', [TrainingPhaseController::class, 'assignList'])->name('training.assign.list');
Route::get('/training/view/{id}',[TrainingPhaseController::class,'viewAssignment'])->name('training.assign.view');
Route::post('/training/phase-hr-review/{id}', [TrainingPhaseController::class, 'phaseHrReview']);
Route::delete('/training/delete/{id}',[TrainingPhaseController::class,'deleteAssignment'])->name('training.assign.delete');
Route::get('/training-report',[TrainingPhaseController::class, 'report'])->name('training.report.index');



Route::prefix('payroll')->name('payroll.')->group(function () {
    Route::get('/', [PayrollController::class, 'index'])->name('index');
    Route::get('/list', [PayrollController::class, 'list'])->name('list');
    Route::post('/import', [PayrollController::class, 'import'])->name('import');
    Route::get('/view/{id}', [PayrollController::class, 'view'])->name('view');
    Route::get('/edit/{id}', [PayrollController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [PayrollController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [PayrollController::class, 'delete'])->name('delete');
    Route::get('/template/download', [PayrollController::class, 'downloadTemplate'])
    ->name('template.download');
});

Route::prefix('tasks')->group(function(){
    Route::get('/utilization',[TaskController::class,'utilization'])->name('tasks.utilization.index');
    Route::get('/utilizationList', [TaskController::class, 'utilizationList'])
        ->name('tasks.resource-utilization.list');    
    Route::get('/',[TaskController::class,'allocation'])->name('tasks.allocation');
    Route::get('/project-modules/{id}',[TaskController::class, 'projectModules'])->name('tasks.project.modules');
    Route::get('/project-team-members/{project}',[TaskController::class, 'projectTeamMembers']);
    Route::get('/list',[TaskController::class,'list'])->name('tasks.list');
    Route::post('/store',[TaskController::class,'store'])->name('tasks.store');
    Route::get('/edit/{id}',[TaskController::class,'edit']);
    Route::get('/view/{id}',[TaskController::class,'view']);
    Route::delete('/delete/{id}',[TaskController::class,'delete']);
    Route::get('/export',[TaskController::class,'export'])->name('tasks.export');
    Route::get('/my-tasks',[TaskController::class,'myTask'])->name('tasks.mytask');
    Route::get('/view-my-task/{id}',[TaskController::class,'viewMyTask']);
    Route::get('/my-task-list',[TaskController::class,'myTaskList'])->name('tasks.mytask.list');
    Route::post('/update', [TaskController::class, 'saveTaskUpdate'])->name('tasks.update');
    Route::post('/task-progress-update',[TaskController::class,'updateProgress'])->name('task.progress.update');
});
use Illuminate\Support\Facades\DB;

Route::get('/test-essl', function () {

    try {

    DB::connection('essl')->getPdo();

    dd('Connected Successfully');

    } catch (\Exception $e) {

        dd($e->getMessage());
    }
});
