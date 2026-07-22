<div class="content-wrapper p-3">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">WFH Requests</h3>
        </div>
       <div>
            @if(in_array(Auth::user()->department_id, [1, 2]))
            <button class="btn btn-success" id="exportBtn">
                <i class="bi bi-file-earmark-excel me-1"></i>
                Export
            </button>
            @endif      
            <button class="btn btn-primary" id="addWFHBtn">
                    <i class="bi bi-plus-lg me-1"></i>
                    Apply WFH
                </button>
            </div> 

            {{--<button class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>
                Add Employee
            </button>  --}}
        </div> 

    </div>
    
    <div class="p-3 border-bottom ">
        <div class="caddrd-body">

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

                 <div class="col-lg-2 col-md-3 col-sm-6">
                    <label class="form-label">Designation</label>

                    <select class="form-select"  id="filter_designation">
                        <option  value=""  selected>Select designation</option>
                        @foreach($designations as $designation)

                            <option value="{{ $designation->id }}">

                                {{ $designation->name }}

                            </option>

                        @endforeach

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
    <div class="p-3">   
    <table class="table table-striped table-hover align-middle w-100 data-table" id="wfhTable">

        <thead>
            <tr>
                <th>Sl No</th>
                <th>Employee Name</th>
                <th>ID</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Designation</th>
                <th>Reason</th>
                <th>Requested Date</th>
                <th>Manager Status</th>
                <th>Actions</th>
            </tr>
        </thead>

    </table>
    </div>
    
</div>

<div class="modal fade" id="wfhModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <form id="wfhForm" enctype="multipart/form-data">
                @csrf

                <div class="modal-header border-0 pb-0">
                    <div>
                        <h4 class="fw-bold mb-1">
                            Apply Work From Home
                        </h4>

                        <small class="text-muted">
                            Enter work-from-home details to submit your remote work request for approval.
                        </small>
                    </div>

                    <button class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <hr>

                    <h6 class="mb-3 text-secondary">
                        General Information
                    </h6>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                From Date
                            </label>

                            <input
                                type="date"
                                class="form-control"
                                name="from_date"
                                required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                To Date
                            </label>

                            <input
                                type="date"
                                class="form-control"
                                name="to_date"
                                required>

                        </div>
                        <div class="col-md-6 mb-3">

                            <label class="form-label">Leave Count</label>

                            <input type="text"
                                   name="wfhcount"
                                   id="wfhcount"
                                   class="form-control"
                                   readonly>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Manager Approval
                            </label>

                            <input
                                type="file"
                                class="form-control"
                                name="manager_approval"
                                required>

                        </div>

                        <div class="col-12">

                            <label class="form-label">
                                Reason
                            </label>

                            <textarea
                                class="form-control"
                                rows="3"
                                name="reason"
                                placeholder="Enter your reason"
                                required></textarea>

                        </div>

                    </div>

                </div>

                <div class="modal-footer border-0">

                    <button
                        class="btn btn-light px-4"
                        data-bs-dismiss="modal"
                        type="button">

                        Cancel

                    </button>

                    <button
                        class="btn btn-primary px-5"
                        type="submit">

                        Apply

                    </button>

                </div>

            </form>

        </div>
    </div>
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
$('#addWFHBtn').click(function(){

    $('#wfhForm')[0].reset();

    $('#wfhModal').modal('show');

});
$(document).on('click', '.view-image', function () {

    $('#previewFrame').attr('src', $(this).data('image'));

    let modal = new bootstrap.Modal(document.getElementById('fileModal'));
    modal.show();
});


$('input[name="from_date"]').change(function () {

    let from = $(this).val();

    if (!from) return;

    let year = from.split('-')[0];

    $('input[name="to_date"]')
        .attr('min', from)
        .attr('max', year + '-12-31')
        .val('');

    $('#wfhcount').val('');
});

$('input[name="to_date"]').change(function () {
    calculateWFHCount();
});
$('input[name="from_date"]').change(function () {
    if ($('input[name="to_date"]').val()) {
        calculateWFHCount();
    }
});


function calculateWFHCount()
{
    
    $.ajax({

        url: "{{ route('calculateWFHCount') }}",

        type: "POST",

        data: {

            _token: $('meta[name="csrf-token"]').attr('content'),

            from_date: $('input[name="from_date"]').val(),

            to_date: $('input[name="to_date"]').val()

        },

        success: function (res) {

            $('#wfhcount').val(res.wfhcount);

        }

    });

}

$('#wfhForm').submit(function(e){

    e.preventDefault();

    let formData=new FormData(this);

    $.ajax({

        url:"{{ route('wfh.store') }}",

        type:"POST",

        data:formData,

        processData:false,

        contentType:false,

        success:function(res){

            Swal.fire(
                'Success',
                res.message,
                'success'
            );

            $('#wfhModal').modal('hide');

            table.ajax.reload();

        },

        error:function(xhr){

            Swal.fire(
                'Error',
                'Validation failed.',
                'error'
            );

        }

    });

});
$('#exportBtn').click(function () {

    let params = $.param({
        from_date: $('#from_date').val(),
        to_date: $('#to_date').val(),
        status: $('#status').val(),
        filter_designation: $('#filter_designation').val()
    });

    window.location.href =
        "{{ route('wfh.export') }}?" + params;
});

var table = $('#wfhTable').DataTable({

    processing: true,
    serverSide: true,

    ajax: {
        url: "{{ route('wfh.list') }}",
        data: function(d){
            d.from_date = $('#from_date').val();
            d.to_date = $('#to_date').val();
            d.status = $('#status').val();
            d.filter_designation = $('#filter_designation').val();
        }
    },

    columns: [
            { data:'DT_RowIndex', name:'DT_RowIndex', orderable:false, searchable:false },
            { data:'employee_name', name:'employee_name' },
            { data:'employee_id', name:'employee_id' },
            { data:'from_date', name:'from_date' },
            { data:'to_date', name:'to_date' },
            { data:'designation', name:'designation' },
            { data:'reason', name:'reason' },
            { data:'created_at', name:'created_at' },
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
        title: 'Approve WFH Request?',
        icon: 'question',
        showCancelButton: true
    }).then((result)=>{

        if(result.isConfirmed){

            $.ajax({

                url:'/wfh-requests/'+id+'/approve',
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
        title: 'Reject WFH Request?',
        icon: 'warning',
        showCancelButton: true
    }).then((result)=>{

        if(result.isConfirmed){

            $.ajax({

                url:'/wfh-requests/'+id+'/reject',
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