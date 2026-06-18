<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AssetRequestController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\EmployeeOffboardController;
use App\Http\Controllers\TrainingPhaseController;

// Handle login
Route::get('/', function () { return view('auth.login'); })->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::view('/sample-page', 'pages.samplepage')->name('samplepage');
// Dashboard (protected)
Route::get('/dashboard', function () { return view("dashboard");})->name('dashboard')->middleware('auth');
Route::view('/dashboard-content', 'pages.dashboard-content')->name('dashboard.content');

// Route::view('/employee-directory', 'pages.employee-directory')->name('employee-directory');
// Route::view('/onboard-employee', 'pages.onboard-employee')->name('onboard-employee');
//employee
Route::get('/employees',[EmployeeController::class, 'index'])->name('employees.index');
Route::get('/employee-list',[EmployeeController::class, 'employeeList'])->name('employees.list');
Route::get('/employees/export',[EmployeeController::class, 'exportEmployees'])->name('employees.export');

Route::get('/employee-directory',[EmployeeController::class, 'employeeDirectory'])->name('employeedirectory.index');
Route::get('/employeeOnboard-list',[EmployeeController::class, 'employeeOnboardList'])->name('onboard.list');
Route::get('/onboard/export', [EmployeeController::class, 'onboardExport'])->name('onboard.export');
Route::get('/employee/details/{id}', [EmployeeController::class, 'employeeDetails'])->name('employee.details');
Route::post('/employee/store', [EmployeeController::class, 'store'])->name('employee.store');
Route::post('/employee/update/{id}', [EmployeeController::class, 'update'])->name('employee.update');

Route::get('/employees/edit/{id}', [EmployeeController::class, 'edit'])->name('employees.edit');
Route::delete('/employees/delete/{id}', [EmployeeController::class, 'destroy'])->name('employees.delete');
Route::get('/employees-by-department',[EmployeeController::class,'employeesByDepartment'])->name('employees.department');

Route::prefix('attendance')->group(function () {

    Route::get('/capture', [AttendanceController::class, 'capture'])
        ->name('attendance.capture');

    Route::get('/schedule', [AttendanceController::class, 'schedule'])
        ->name('attendance.schedule');

    Route::get('/tracking', [AttendanceController::class, 'tracking'])
        ->name('attendance.tracking');

    Route::get('/regularization', [AttendanceController::class, 'regularization'])
        ->name('attendance.regularization');

    Route::get('/summary', [AttendanceController::class, 'summary'])
        ->name('attendance.summary');

    Route::get('/reports', [AttendanceController::class, 'reports'])
        ->name('attendance.reports');

});

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
Route::delete('/project-delete/{id}',[ProjectController::class,'delete'])->name('project.delete');
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

use Illuminate\Support\Facades\DB;

Route::get('/test-essl', function () {

    try {

    DB::connection('essl')->getPdo();

    dd('Connected Successfully');

    } catch (\Exception $e) {

        dd($e->getMessage());
    }
});