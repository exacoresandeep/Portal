<div class="content-wrapper p-3">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">Leave Requests</h3>
        </div>
       <div>
        @if(in_array(Auth::user()->department_id, [1, 2]))
             <button class="btn btn-success" id="exportBtn">
                <i class="bi bi-file-earmark-excel me-1"></i>
                Export
            </button>
        @endif      
           <button class="btn btn-primary" id="addLeaveBtn">
                <i class="bi bi-plus-lg me-1"></i>
                Apply Leave
            </button>
        </div> 

    </div>
    <div class="row mb-4">

    <div class="col-lg-6">

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span>
                        <i class="bi bi-calendar-check-fill text-primary me-2"></i>
                        Total Annual Leave
                    </span>

                    <span>
                        <strong class="text-primary" id="total_leave">36</strong> Days
                    </span>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span>
                        <i class="bi bi-calendar-minus-fill text-warning me-2"></i>
                        Used Leave
                    </span>

                    <span>
                        <strong class="text-warning" id="used_leave">16</strong> Days
                    </span>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <span>
                        <i class="bi bi-calendar-plus-fill text-success me-2"></i>
                        Balance Leave
                    </span>

                    <span>
                        <strong class="text-success" id="balance_leave">20</strong> Days
                    </span>
                </div>

            </div>

        </div>

    </div>
    
    <div class="col-lg-6">

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">
                    <span>
                        <i class="bi bi-heart-pulse-fill text-success me-2"></i>
                        Sick Leave
                    </span>

                    <span>
                        <strong class="text-success" id="sick_balance">0</strong>/<span id="sick_total">0</span> Days
                    </span>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <span>
                        <i class="bi bi-briefcase-fill text-warning me-2"></i>
                        Casual Leave
                    </span>

                    <span>
                        <strong class="text-success" id="casual_balance">0</strong>/<span id="casual_total">0</span> Days
                    </span>
                </div>

                <div class="d-flex justify-content-between">
                    <span>
                        <i class="bi bi-calendar-check-fill text-danger me-2"></i>
                        Earned Leave
                    </span>

                    <span>
                        <strong class="text-success" id="earned_balance">0</strong>/<span id="earned_total">0</span> Days
                    </span>
                </div>

            </div>

        </div>

    </div>

</div>
<hr>
    <div class="pb-3 mb-3 border-bottom ">
        <div class="card-body">

            <div class="row g-3 align-items-end">

                <div class="col-md-2">
                    <label class="form-label">From Date</label>
                    <input type="date" id="from_date" class="form-control">
                </div>

                <div class="col-md-2">
                    <label class="form-label">To Date</label>
                    <input type="date" id="to_date" class="form-control">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select id="status" class="form-select ">
                        <option value="">All Status</option>
                        <option value="Pending">Pending</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>

                

                <div class="col-md-2">
                    <label class="form-label">Leave Type</label>
                    <select id="leave_type" class="form-select">
                        <option value="">All Types</option>
                        <option value="Sick">Sick</option>
                        <option value="Casual">Casual</option>
                        <option value="Earned">Earned</option>
                        {{-- <option value="WFH">WFH</option> --}}
                        <option value="Maternity">Maternity</option>
                        <option value="LOP">LOP</option>
                    </select>
                </div>

                
                <div class="col-md-2">
                    <button id="searchBtn" class="btn btn-primary">
                        Search
                    </button>
                </div>

            </div>
        </div>
    </div>

    <table class="table table-striped table-hover align-middle w-100 data-table" id="leaveTable">

        <thead>
            <tr>
                <th>Sl No</th>
                <th>Employee Name</th>
                <th>ID</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Leave Count</th>
                <th>Applied Date</th>
                <th>Leave Type</th>
                <th>Reason</th>
                <th>Attachment</th>
                <th>Manager Approval</th>
                <th>Actions</th>
            </tr>
        </thead>

    </table>
</div>



<div class="modal fade" id="fileModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attachment Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <iframe id="previewFrame"
                        width="100%"
                        height="600"
                        frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>
{{-- <div class="modal fade" id="leaveModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form id="leaveForm" enctype="multipart/form-data">

                @csrf

                <div class="modal-header">
                    <h5>Create Leave Request</h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>From Date</label>
                            <input
                                type="date"
                                name="from_date"
                                class="form-control"
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>To Date</label>
                            <input
                                type="date"
                                name="to_date"
                                class="form-control"
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Leave Type</label>

                            <select
                                name="leave_type"
                                class="form-select"
                                required>

                                <option value="">Select</option>
                                <option value="Sick">Sick</option>
                                <option value="Casual">Casual</option>
                                <option value="Earned">Earned</option>
                                <option value="Maternity">Maternity</option>
                                <option value="LOP">LOP</option>

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Attachment</label>

                            <input
                                type="file"
                                name="attachment"
                                class="form-control">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Manager Approval <span class="text-danger">*</span></label>
                            <input
                                type="file"
                                name="manager_approval"
                                class="form-control"
                                required>
                        </div>

                        <div class="col-12">

                            <label>Reason</label>

                            <textarea
                                class="form-control"
                                name="reason"
                                rows="4"></textarea>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button
                        class="btn btn-success"
                        type="submit">
                        Submit
                    </button>

                </div>

            </form>

        </div>
    </div>
</div> --}}
<div class="modal fade" id="leaveModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form id="leaveForm" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5>Create Leave Request</h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>From Date <span class="text-danger">*</span></label>

                            <input type="date"
                                   name="from_date"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>To Date <span class="text-danger">*</span></label>

                            <input type="date"
                                   name="to_date"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Leave Category</label>

                            <select name="leavecategory"
                                    class="form-select">

                                <option value="Full Day">Full Day</option>
                                <option value="Half Day">Half Day</option>

                            </select>

                        </div>

                        <div class="col-md-6 mb-3 sessionDiv" style="display:none;">

                            <label>Leave Session</label>

                            <select name="leavesession"
                                    class="form-select">

                                <option value="AM">AM</option>
                                <option value="PM">PM</option>

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Leave Count</label>

                            <input type="text"
                                   name="leavecount"
                                   id="leavecount"
                                   class="form-control"
                                   readonly>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Leave Type</label>

                            <select name="leave_type"
                                    class="form-select"
                                    required>

                                <option value="">Select</option>
                                <option value="Sick">Sick</option>
                                <option value="Casual">Casual</option>
                                <option value="Earned">Earned</option>
                                <option value="Maternity">Maternity</option>
                                <option value="LOP">LOP</option>

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Attachment</label>

                            <input type="file"
                                   name="attachment"
                                   class="form-control">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Manager Approval <span class="text-danger">*</span></label>

                            <input type="file"
                                   name="manager_approval"
                                   class="form-control"
                                   required>

                        </div>

                        <div class="col-12">

                            <label>Reason</label>

                            <textarea class="form-control"
                                      name="reason"
                                      rows="4"></textarea>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button class="btn btn-success"
                            type="submit">
                        Submit
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>
<script>
    $('#addLeaveBtn').click(function () {

        $('#leaveForm')[0].reset();

        $('#leaveModal').modal('show');

    });
    $('#leaveForm').submit(function(e){

        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({

            url: "{{ route('leave.store') }}",

            type: "POST",

            data: formData,

            processData: false,

            contentType: false,

            success:function(res){

                $('#leaveModal').modal('hide');

                Swal.fire(
                    'Success',
                    res.message,
                    'success'
                );

                $('#leaveTable')
                    .DataTable()
                    .ajax
                    .reload();

            },

            error:function(xhr){

                let errors = xhr.responseJSON.errors;

                let message = '';

                $.each(errors,function(k,v){

                    message += v[0] + '<br>';

                });

                Swal.fire({
                    icon:'error',
                    title:'Validation Error',
                    html:message
                });

            }

        });

    });
    $('#exportBtn').click(function () {

    let params = $.param({
        from_date: $('#from_date').val(),
        to_date: $('#to_date').val(),
        status: $('#status').val(),
        leave_type: $('#leave_type').val()
    });

    window.location.href =
        "{{ route('leave.export') }}?" + params;
});
$(document).on('click', '.view-image', function () {

    $('#previewFrame').attr('src', $(this).data('image'));

    let modal = new bootstrap.Modal(document.getElementById('fileModal'));
    modal.show();
});
var table = $('#leaveTable').DataTable({

    processing: true,
    serverSide: true,

    ajax: {
        url: "{{ route('leave.list') }}",
        data: function(d){

            d.from_date = $('#from_date').val();
            d.to_date = $('#to_date').val();
            d.status = $('#status').val();
            d.leave_type = $('#leave_type').val();
        }
    },

    columns: [
            { data:'DT_RowIndex', name:'DT_RowIndex', orderable:false, searchable:false },
            { data:'employee_name', name:'employee_name' },
            { data:'employee_id', name:'employee_id' },
            { data:'from_date', name:'from_date' },
            { data:'to_date', name:'to_date' },
            { data:'leave_count', name:'leave_count' },
            { data:'created_at', name:'created_at' },
            { data:'leave_type', name:'leave_type' },
            { data:'reason', name:'reason' },
            { data:'attachment', name:'attachment', orderable:false, searchable:false },
            { data:'manager_approval', name:'manager_approval' ,orderable:false, searchable:false}, 
            { data:'action', name:'action', orderable:false, searchable:false }
        ]
});

$('#searchBtn').click(function(){
    table.ajax.reload();
});

$(document).on('click','.approveLeave',function(){

    let id = $(this).data('id');

    Swal.fire({
        title: 'Approve Leave?',
        icon: 'question',
        showCancelButton: true
    }).then((result)=>{

        if(result.isConfirmed){

            $.ajax({

                url:'/leave-requests/'+id+'/approve',
                type:'POST',

                data:{
                    _token:$('meta[name="csrf-token"]').attr('content')
                },

                success:function(response){

                    Swal.fire(
                        'Success',
                        response.message,
                        'success'
                    );

                    table.ajax.reload(null,false);
                }
            });
        }
    });
});

$(document).on('click','.rejectLeave',function(){

    let id = $(this).data('id');

    Swal.fire({
        title: 'Reject Leave?',
        icon: 'warning',
        showCancelButton: true
    }).then((result)=>{

        if(result.isConfirmed){

            $.ajax({

                url:'/leave-requests/'+id+'/reject',
                type:'POST',

                data:{
                    _token:$('meta[name="csrf-token"]').attr('content')
                },

                success:function(response){

                    Swal.fire(
                        'Success',
                        response.message,
                        'success'
                    );

                    table.ajax.reload(null,false);
                }
            });
        }
    });
});
loadLeaveSummary();

function loadLeaveSummary() {

    $.ajax({

        url: "{{ route('leave.summary') }}",

        type: "GET",

        success: function(res) {

            $('#total_leave').text(res.total_leave);
            $('#used_leave').text(res.used_leave);
            $('#balance_leave').text(res.balance_leave);

            $('#sick_balance').text(res.sick.balance);
            $('#sick_total').text(res.sick.total);

            $('#casual_balance').text(res.casual.balance);
            $('#casual_total').text(res.casual.total);

            $('#earned_balance').text(res.earned.balance);
            $('#earned_total').text(res.earned.total);

        },

        error: function() {

            console.log('Unable to load leave summary.');

        }

    });

}
$('input[name="from_date"]').change(function () {

    let from = $(this).val();

    if (!from) return;

    let year = from.split('-')[0];

    $('input[name="to_date"]')
        .attr('min', from)
        .attr('max', year + '-12-31')
        .val('');

    $('#leavecount').val('');
});

$(document).on('click', '.deleteLeave', function () {

    let btn = $(this);
    let id = btn.data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "This leave request will be removed permanently.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Remove',
        cancelButtonText: 'Cancel'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: "{{ route('leave.delete') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function (response) {

                    if (response.status) {

                        $('#leaveTable').DataTable().ajax.reload(null, false);

                        Swal.fire({
                            icon: 'success',
                            title: 'Removed!',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });

                    }
                },
                error: function () {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong.'
                    });

                }
            });

        }

    });

});
$('select[name="leavecategory"]').change(function () {

    if ($(this).val() == 'Half Day') {

        $('.sessionDiv').show();

        let from = $('input[name="from_date"]').val();

        $('input[name="to_date"]')
            .val(from)
            .prop('readonly', true);

        $('#leavecount').val('0.5');

    } else {

        $('.sessionDiv').hide();

        $('input[name="to_date"]')
            .prop('readonly', false);

        $('#leavecount').val('');

    }

});


$('input[name="to_date"]').change(function () {

    calculateLeaveCount();

});

$('input[name="from_date"]').change(function () {

    if ($('input[name="to_date"]').val()) {

        calculateLeaveCount();

    }

});


function calculateLeaveCount()
{
    if ($('select[name="leavecategory"]').val() == 'Half Day') {

        $('#leavecount').val('0.5');
        return;
    }

    $.ajax({

        url: "{{ route('getleaveCount') }}",

        type: "POST",

        data: {

            _token: $('meta[name="csrf-token"]').attr('content'),

            from_date: $('input[name="from_date"]').val(),

            to_date: $('input[name="to_date"]').val()

        },

        success: function (res) {

            $('#leavecount').val(res.leavecount);

        }

    });

}
</script>