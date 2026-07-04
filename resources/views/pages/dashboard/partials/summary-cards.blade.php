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

                            <h5 class="text-primary mb-0">
                                150
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

                            <h5 class="text-success mb-0">
                                100
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

                            <h5 class="text-danger mb-0">
                                15
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

                            <h5 class="text-info mb-0">
                                10
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

                            <h5 class="text-purple mb-0">
                                158
                            </h5>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
var working = "00:00:00";
var breaking = "00:00:00";
var lastDirection = "";
var timer = null;

loadAttendance();

function loadAttendance() {

    $.ajax({

        url: "{{ route('dashboard.attendance') }}",
        type: "GET",

        success: function(res){

            working = res.workingHours;
            breaking = res.breakHours;
            lastDirection = res.lastDirection;

            if(res.checkIn == "Not Checked In"){

                $("#checkInTime")
                    .removeClass("text-success")
                    .addClass("text-danger")
                    .html('<i class="bi bi-x-circle-fill"></i> Not Checked');

            }else{

                $("#checkInTime")
                    .removeClass("text-danger")
                    .addClass("text-success")
                    .html('<i class="bi bi-check-circle-fill"></i> ' + res.checkIn);

            }

            $("#workingHours").text(working);
            $("#breakHours").text(breaking);

            startTimer();
        }

    });

}

function tick(time) {

    let p = time.split(':');

    let sec = parseInt(p[0]) * 3600 +
              parseInt(p[1]) * 60 +
              parseInt(p[2]);

    sec++;

    let h = String(Math.floor(sec / 3600)).padStart(2, '0');
    let m = String(Math.floor((sec % 3600) / 60)).padStart(2, '0');
    let s = String(sec % 60).padStart(2, '0');

    return h + ":" + m + ":" + s;
}

function startTimer() {

    // Prevent multiple timers
    if (timer) {
        clearInterval(timer);
    }

    timer = setInterval(function () {

        if (lastDirection === 'in') {

            working = tick(working);
            $("#workingHours").text(working);

        } else if (lastDirection === 'out') {

            breaking = tick(breaking);
            $("#breakHours").text(breaking);

        }

    }, 1000);

}
setInterval(function () {
    loadAttendance();
}, 60000); // Refresh every 60 seconds
</script>