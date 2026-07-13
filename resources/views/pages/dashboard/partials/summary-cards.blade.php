<div class="container-fluid">

    <div class="row align-items-center mb-4 mt-2">

        <!-- Welcome -->
        <div class="col-lg-5">

            @php
                $hour = now()->hour;

                if ($hour < 12) {
                    $greeting = 'Good Morning';
                } elseif ($hour < 17) {
                    $greeting = 'Good Afternoon';
                } else {
                    $greeting = 'Good Evening';
                }
            @endphp

            <h5 class="fw-bold mb-1">
                {{ $greeting }}, {{ auth()->user()->name }}
            </h5>

            <p class="text-muted mb-0">
                Manage employees, projects, and approvals efficiently.
            </p>

        </div>

        <!-- Attendance Cards -->
        <div class="col-lg-7">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body py-3">

                    <div class="row text-center top-bar">

                        <div class="col">

                            <div class="d-flex align-items-center justify-content-center">

                                <div class="icon bg-success-subtle text-success me-3">
                                    <i class="bi bi-box-arrow-in-right"></i>
                                </div>

                                <div class="text-start">

                                    <small class="text-muted d-block">
                                        Check-In Time
                                    </small>

                                    <h6 id="checkInTime" class="mb-0"></h6>

                                </div>

                            </div>

                        </div>

                        <div class="col border-start">

                            <div class="d-flex align-items-center justify-content-center">

                                <div class="icon bg-primary-subtle text-primary me-3">
                                    <i class="bi bi-stopwatch"></i>
                                </div>

                                <div class="text-start">

                                    <small class="text-muted d-block">
                                        Working Hours
                                    </small>

                                    <h5 class="mb-0 text-primary">
                                        <span id="workingHours"></span>
                                    </h5>

                                </div>

                            </div>

                        </div>

                        <div class="col border-start">

                            <div class="d-flex align-items-center justify-content-center">

                                <div class="icon bg-warning-subtle text-warning me-3">
                                    <i class="bi bi-cup-hot"></i>
                                </div>

                                <div class="text-start">

                                    <small class="text-muted d-block">
                                        Break Time
                                    </small>

                                    <h5 class="mb-0 text-warning">
                                        <span id="breakHours"></span>
                                    </h5>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Statistics -->
@php
    $departmentId = session('department_id');
@endphp

@if($departmentId == 1 || $departmentId == 2)
    <div class="row g-3">

        <div class="col-lg col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="stat-icon bg-primary-subtle text-primary">
                            <i class="bi bi-people"></i>
                        </div>

                        <div class="ms-3">

                            <small class="text-muted">
                                Total Employees
                            </small>

                            <h5 class="text-primary mb-0" id="totalEmployees">
                                0
                            </h5>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="stat-icon bg-success-subtle text-success">
                            <i class="bi bi-person-check"></i>
                        </div>

                        <div class="ms-3">

                            <small class="text-muted">
                                Present Today
                            </small>

                            <h5 class="text-success mb-0" id="presentToday">
                                0
                            </h5>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="stat-icon bg-danger-subtle text-danger">
                            <i class="bi bi-person-x"></i>
                        </div>

                        <div class="ms-3">

                            <small class="text-muted">
                                On Leave
                            </small>

                            <h5 class="text-danger mb-0" id="onLeave">
                                0
                            </h5>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="stat-icon bg-info-subtle text-info">
                            <i class="bi bi-kanban"></i>
                        </div>

                        <div class="ms-3">

                            <small class="text-muted">
                                Total Projects
                            </small>

                            <h5 class="text-info mb-0" id="totalProjects">
                                0
                            </h5>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="stat-icon bg-purple">
                            <i class="bi bi-list-task"></i>
                        </div>

                        <div class="ms-3">

                            <small class="text-muted">
                                Total Tasks
                            </small>

                            <h5 class="text-purple mb-0" id="totalTasks">
                                0
                            </h5>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
@else
    <div class="row g-3">

        <!-- Total Tasks -->
        <div class="col-lg col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">

                        <div class="stat-icon bg-primary-subtle text-primary">
                            <i class="bi bi-list-task"></i>
                        </div>

                        <div class="ms-3">
                            <small class="text-muted d-block">Total Tasks</small>
                            <h5 class="mb-0 text-primary" id="totalTasks">0</h5>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Task Completed -->
        <div class="col-lg col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">

                        <div class="stat-icon bg-success-subtle text-success">
                            <i class="bi bi-check-circle"></i>
                        </div>

                        <div class="ms-3">
                            <small class="text-muted d-block">Task Completed</small>
                            <h5 class="mb-0 text-success" id="completedTasks">0</h5>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Total Projects -->
        <div class="col-lg col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">

                        <div class="stat-icon bg-pink-subtle text-pink">
                            <i class="bi bi-kanban"></i>
                        </div>

                        <div class="ms-3">
                            <small class="text-muted d-block">Total Projects</small>
                            <h5 class="mb-0 text-pink" id="totalProjects">0</h5>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Leave Balance -->
        <div class="col-lg col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">

                        <div class="stat-icon bg-warning-subtle text-warning">
                            <i class="bi bi-emoji-smile"></i>
                        </div>

                        <div class="ms-3">
                            <small class="text-muted d-block">Leave Balance</small>
                            <h5 class="mb-0 text-warning">
                                <span id="leaveBalance">0</span>
                                <small class="text-muted">Days</small>
                            </h5>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance -->
        <div class="col-lg col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">

                        <div class="stat-icon bg-info-subtle text-info">
                            <i class="bi bi-calendar-check"></i>
                        </div>

                        <div class="ms-3">
                            <small class="text-muted d-block">Attendance</small>
                            <h5 class="mb-0 text-info">
                                <span id="attendanceDays">0</span>
                                <small class="text-muted">Days in this month</small>
                            </h5>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endif
</div>

<script>

</script>