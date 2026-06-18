<div class="content-wrapper p-3">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">Leave Requests</h3>
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
                    <label class="form-label">Manager Status</label>
                    <select id="manager_status" class="form-select">
                        <option value="">All Manager Status</option>
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
                <th>Manager Status</th>
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

<script>
    $('#exportBtn').click(function () {

    let params = $.param({
        from_date: $('#from_date').val(),
        to_date: $('#to_date').val(),
        status: $('#status').val(),
        manager_status: $('#manager_status').val(),
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
            d.manager_status = $('#manager_status').val(); 
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
             { data:'manager_status', name:'manager_status' ,orderable:false, searchable:false}, 
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

</script>