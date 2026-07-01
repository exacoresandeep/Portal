<div class="content-wrapper p-3">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Attendance Capture</h3>
        </div>
       <div>
            <button class="btn btn-success" id="exportBtn">
                <i class="bi bi-file-earmark-excel me-1"></i>
                Export
            </button>
            {{-- <button class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>
                Add Employee
            </button>  --}}
        </div> 
    </div>
    <div class="pb-3 mb-3 border-bottom ">
        <div class="card-body">
            <div class="row g-3 align-items-end">

                <!-- From Date -->
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <label class="form-label">Status</label>
                    <select class="form-select" id="status_filter">
                        <option value="" selected>Select Status</option>
                        <option>Absent</option>
                        <option>Present</option>
                    </select>
                </div>
               
                <!-- Search Button -->
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <button type="button" class="btn btn-primary w-100" id="searchBtn">
                        Search
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
       <table class="table table-striped table-hover align-middle w-100 data-table"
       id="attendanceTable">
            <thead class="table-light">
                <tr>
                    <th>Sl No.</th>
                    <th>Employee Name</th>
                    <th>Employee ID</th>
                    <th>In-Time</th>
                    <th>Out-Time</th>
                    <th>Work</th>
                    <th>Over Time</th>
                    <th>Total Time</th>
                    <th>Status</th>
                </tr>
            </thead>
        </table>
    </div>       
</div>

<script>

$(document).ready(function () {    
    $('#exportBtn').click(function () {

        let status = $('#status_filter').val();

        window.location.href =
            "{{ route('attendancecapture.export') }}?status=" + status;
    });

    let table = $('#attendanceTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('attendance.captureList') }}",
            data: function (d) {
                 d.status = $('#status_filter').val() || '';
            }
        },
       columns: [
        {
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false
        },
        {
            data: 'employee_name',
            name: 'employee_name'
        },
        {
            data: 'emp_id',
            name: 'emp_id'
        },
        {
            data: 'in_time',
            name: 'in_time',
            orderable: false,
            searchable: false
        },
        {
            data: 'out_time',
            name: 'out_time',
            orderable: false,
            searchable: false
        },
        {
            data: 'work_time',
            name: 'work_time',
            orderable: false,
            searchable: false
        },
        {
            data: 'overtime',
            name: 'overtime',
            orderable: false,
            searchable: false
        },
        {
            data: 'total_time',
            name: 'total_time',
            orderable: false,
            searchable: false
        },
        {
            data: 'status',
            name: 'status'
        }
    ]
    });

    $('#searchBtn').click(function () {
        table.ajax.reload();
    });
});
</script>