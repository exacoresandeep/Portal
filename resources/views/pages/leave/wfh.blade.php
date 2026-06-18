<div class="content-wrapper p-3">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">WFH Requests</h3>
        </div>
       <div>
            <button class="btn btn-success" id="exportBtn">
                <i class="bi bi-file-earmark-excel me-1"></i>
                Export
            </button>
            {{--<button class="btn btn-primary">
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



<script>
$('#exportBtn').click(function () {

    let params = $.param({
        from_date: $('#from_date').val(),
        to_date: $('#to_date').val(),
        status: $('#status').val(),
        manager_status: $('#manager_status').val(),
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
            d.manager_status = $('#manager_status').val(); 
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
             { data:'manager_status', name:'manager_status',orderable:false, searchable:false }, 
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