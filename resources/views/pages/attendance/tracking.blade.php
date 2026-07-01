<div class="content-wrapper p-3">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Attendance Tracking</h3>
        </div>
        <div class="d-flex justify-content-end mb-3">

                <button class="btn btn-success"
                        id="exportBtn">
                    <i class="fas fa-file-excel"></i>
                    Export
                </button>

            </div>
    </div>

    <div class="mb-3">

            <div class="row">

                <div class="col-md-2">
                    <label>From Date</label>
                    <input type="date" class="form-control" id="from_date">
                </div>

                <div class="col-md-2">
                    <label>To Date</label>
                    <input type="date" class="form-control" id="to_date">
                </div>

                <div class="col-md-2">
                    <label>Department</label>
                    <select class="form-select" id="department_id">
                        <option value="">Select Department</option>

                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">
                                {{ $department->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-2">
                    <label>Status</label>
                    <select class="form-select" id="status">
                        <option value="">Select Status</option>
                        <option value="Present">Present</option>
                        <option value="Half Day">Half Day</option>
                        <option value="On Leave">On Leave</option>
                        <option value="Absent">Absent</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100" id="searchBtn">
                        Search
                    </button>
                </div>

                

            </div>

    </div>

    <table class="table table-striped table-hover align-middle w-100 data-table"
            id="attendanceTable">

        <thead>
            <tr>
                <th>Sl No</th>
                <th>Date</th>
                <th>Employee ID</th>
                <th>Employee Name</th>
                <th>Department</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Hours</th>
                <th>Status</th>
            </tr>
        </thead>

    </table>

</div>
<script>
    $(document).ready(function () {

    let table = $('#attendanceTable').DataTable({

        processing: true,
        serverSide: true,

        ajax: {

            url: "{{ route('attendance.tracking.list') }}",

            data: function (d) {

                d.from_date = $('#from_date').val();
                d.to_date = $('#to_date').val();
                d.department_id = $('#department_id').val();
                d.status = $('#status').val();
            }
        },

        columns: [

            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },

            {data: 'emp_id', name: 'emp_id'},
            {data: 'date', name: 'date'},
            {data: 'employee_name', name: 'employee_name'},
            {data: 'department', name: 'department'},
            {data: 'check_in', name: 'check_in'},
            {data: 'check_out', name: 'check_out'},
            {data: 'hours', name: 'hours'},
            {data: 'status', name: 'status'}
        ]
    });

    $('#searchBtn').click(function () {

        table.ajax.reload();
    });

    $('#exportBtn').click(function () {

        let url =
            "{{ route('attendance.tracking.export') }}" +
            '?from_date=' + $('#from_date').val() +
            '&to_date=' + $('#to_date').val() +
            '&department_id=' + $('#department_id').val() +
            '&status=' + $('#status').val();

        window.location.href = url;
    });

});
</script>