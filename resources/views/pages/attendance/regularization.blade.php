<div class="content-wrapper p-3">
    <!-- Heading -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                Regularization Request
            </h4>
        </div>

        <div>
            {{-- <button
                type="button"
                id="exportBtn"
                class="btn btn-success">

                <i class="fa fa-download me-1"></i>
                Export

            </button> --}}
        </div>

    </div>

    <!-- Filters -->

    <div class="row g-3 mb-4">

        <div class="col-md-2">

            <label class="form-label">
                From Date
            </label>

            <input
                type="date"
                id="from_date"
                class="form-control">

        </div>

        <div class="col-md-2">

            <label class="form-label">
                To Date
            </label>

            <input
                type="date"
                id="to_date"
                class="form-control">

        </div>

        <div class="col-md-3">

            <label class="form-label">
                Department
            </label>

            <select
                id="department_id"
                class="form-select">

                <option value="">
                    Select Department
                </option>

                @foreach($departments as $department)

                    <option
                        value="{{ $department->id }}">

                        {{ $department->name }}

                    </option>

                @endforeach

            </select>

        </div>

        <div class="col-md-2">

            <label class="form-label">
                Status
            </label>

            <select
                id="status"
                class="form-select">

                <option value="">
                    Select Status
                </option>

                <option value="Pending">
                    Pending
                </option>

                <option value="Approved">
                    Approved
                </option>

                <option value="Rejected">
                    Rejected
                </option>

            </select>

        </div>

        <div class="col-md-2 d-flex align-items-end">

            <button
                type="button"
                id="searchBtn"
                class="btn btn-primary w-100">

                Search

            </button>

        </div>

    </div>

    <!-- Table -->

    <table
        id="regularizationTable"
        class="table table-striped table-hover align-middle w-100 data-table">

        <thead>

            <tr>

                <th>Sl No.</th>

                <th>Employee ID</th>

                <th>Employee Name</th>

                <th>Attendance Date</th>

                <th>Requested Type</th>

                <th>Reason</th>

                <th>Requested On</th>

                <th>Action</th>

            </tr>

        </thead>

    </table>

</div>

<!-- Approve Regularization Modal -->
<div class="modal fade"
     id="approveModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <form id="approveForm">

                @csrf

                <input type="hidden"
                       name="request_id"
                       id="approveRequestId">

                <div class="modal-header border-0">

                    <div>
                        <h5 class="fw-bold mb-1">
                            Approve Regularization Request
                        </h5>

                        <small class="text-muted">
                            Provide the approved time details for the request.
                        </small>
                    </div>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="row mb-4">

                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Employee Name
                            </small>

                            <div class="fw-semibold"
                                 id="approveEmployeeName">
                            </div>

                        </div>

                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Requested On
                            </small>

                            <div class="fw-semibold"
                                 id="approveRequestedOn">
                            </div>

                        </div>

                    </div>

                    <div class="row mb-4">

                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Reason
                            </small>

                            <div class="fw-semibold"
                                 id="approveReason">
                            </div>

                        </div>

                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Request Type
                            </small>

                            <div class="fw-semibold"
                                 id="approveRequestType">
                            </div>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">

                            <label class="form-label">
                                Punch Type
                            </label>

                            <select id="approveDirection" class="form-select"
                                    name="direction"
                                    required >

                                <option value="">
                                    Select punch type
                                </option>

                                <option value="in">
                                    Punch In
                                </option>

                                <option value="out">
                                    Punch Out
                                </option>

                            </select>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">
                                Select Time
                            </label>

                            <input type="time"
                                   class="form-control"
                                   name="time"
                                   required>

                        </div>

                    </div>

                </div>

                <div class="modal-footer border-0">

                    <button type="button"
                            class="btn btn-light px-4"
                            data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button type="submit"
                            class="btn btn-primary px-4">

                        Submit

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
<script>
    var table = $('#regularizationTable').DataTable({

    processing: true,

    serverSide: true,

    ajax: {

        url: "{{ route('attendance.regularization.list') }}",

        data: function(d){

            d.from_date =
                $('#from_date').val();

            d.to_date =
                $('#to_date').val();

            d.department_id =
                $('#department_id').val();

            d.status =
                $('#status').val();

        }

    },

    columns: [

        {
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            searchable: false,
            orderable: false
        },

        {
            data: 'emp_id',
            name: 'emp_id'
        },

        {
            data: 'employee_name',
            name: 'employee_name'
        },

        {
            data: 'attendance_date',
            name: 'attendance_date'
        },

        {
            data: 'request_type',
            name: 'request_type'
        },

        {
            data: 'reason',
            name: 'reason'
        },

        {
            data: 'created_at',
            name: 'created_at'
        },

        {
            data: 'action',
            name: 'action',
            searchable: false,
            orderable: false
        }

    ]

});
$('#searchBtn').click(function(){

    table.ajax.reload();

});
$('#exportBtn').click(function(){

    let url =
        "{{ route('attendance.regularization.export') }}"
        + '?from_date=' + $('#from_date').val()
        + '&to_date=' + $('#to_date').val()
        + '&department_id=' + $('#department_id').val()
        + '&status=' + $('#status').val();

    window.location.href = url;

});

$(document).on(
    'click',
    '.rejectBtn',
    function(){

        let id = $(this).data('id');

        Swal.fire({

            title: 'Reject Request?',

            text: 'Are you sure you want to reject this request?',

            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#dc3545',

            confirmButtonText: 'Reject'

        }).then((result)=>{

            if(result.isConfirmed){

                $.post(
                    "{{ url('attendance/regularization/reject') }}/"+id,
                    {
                        _token:
                        "{{ csrf_token() }}"
                    },
                    function(res){

                        Swal.fire(
                            'Rejected!',
                            res.message,
                            'success'
                        );

                        $('.data-table')
                            .DataTable()
                            .ajax
                            .reload();

                    }
                );

            }

        });

    }
);
$(document).on(
    'click',
    '.approveBtn',
    function(){

        let id = $(this).data('id');

        $.get(
            "{{ url('attendance/regularization') }}/"+id,
            function(res){

                $('#approveRequestId').val(res.id);

                $('#approveEmployeeName').text(
                    res.employee.name
                );

                $('#approveRequestedOn').text(
                    res.date
                );

                $('#approveReason').text(
                    res.reason ?? '-'
                );

                $('#approveRequestType').text(
                    res.direction ?? '-'
                );
                 $('#approveDirection').val(
                    res.direction
                );

                $('#approveModal').modal('show');

            }
        );

    }
);

$('#approveForm').submit(function(e){

    e.preventDefault();

    $.ajax({

        url: "{{ route('regularization.approve') }}",

        type: "POST",

        data: $(this).serialize(),

        success: function(res){

            $('#approveModal').modal('hide');

            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: res.message
            });

            $('#regularizationTable')
                .DataTable()
                .ajax
                .reload();

        },

        error: function(xhr){

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: xhr.responseJSON.message
            });

        }

    });

});
</script>