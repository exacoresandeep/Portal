<div class="content-wrapper p-3">

    <div class="d-flex justify-content-between align-items-center mb-4">            
        <div>
            <h3 class="fw-bold mb-1">Expense Request</h3>
        </div>
       <div>
             {{--<button class="btn btn-success" id="exportBtn">
                <i class="bi bi-file-earmark-excel me-1"></i>
                Export
            </button>
            <button class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>
                Add Employee
            </button>  --}}
            <a href="javascript:void(0)"
                id="exportBtn"
                class="btn btn-success">
                   <i class="bi bi-file-earmark-excel me-1"></i> Export
                </a>
        </div> 

    </div> 
    <div class="pb-3 mb-3 border-bottom ">
        <div class="card-body">

            <div class="row g-3 align-items-end">

                <div class="col-md-2">
                    <label class="form-label">Year</label>
                    <select name="year" class="form-select" id="year">
                        @for($year = date('Y') + 1; $year >= 2020; $year--)
                            <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </div>

                 <div class="col-lg-2 col-md-3 col-sm-6">
                    <label class="form-label">Month</label>

                    <select class="form-select"  id="month">
                        <option  value=""  selected>Select</option>
                        <option>January</option>
                        <option>February</option>
                        <option>March</option>
                        <option>April</option>
                        <option>May</option>
                        <option>June</option>
                        <option>July</option>
                        <option>August</option>
                        <option>September</option>
                        <option>October</option>
                        <option>November</option>
                        <option>December</option>

                    </select>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <label class="form-label">Status</label>
                    <select class="form-select" id="status">
                        <option value="" selected >Select</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
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
    <table class="table table-striped table-hover align-middle w-100 data-table" id="expenseTable">

        <thead>
            <tr>
                <th>Sl No .</th>
                <th>Date</th>
                <th>Employee Name</th>
                <th>ID</th>
                <th>Department</th>
                <th>Amount</th>
                <th>Purpose</th>
                <th>Document</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

    </table>
</div>     
<script>
var table = $('#expenseTable').DataTable({

    processing: true,
    serverSide: true,

    ajax: {
        url: "{{ route('expenses.list') }}",

        data: function(d){

            d.year = $('#year').val();
            d.month = $('#month').val();
            d.status = $('#status').val();

        }
    },

    columns: [

        {
            data:'DT_RowIndex',
            searchable:false,
            orderable:false
        },

        {data:'created_at'},
        {data:'employee_name'},
        {data:'employee_code'},
        {data:'department'},
        {data:'amount'},
        {data:'purpose'},
        {data:'document_link'},
        {data:'status'},
        {data:'action'}
    ]
});
$('#searchBtn').click(function(){

    table.ajax.reload();

});

$(document).on('click','.approveBtn',function(){

    let id = $(this).data('id');

    Swal.fire({
        title: 'Approve Expense?',
        text: 'This expense request will be approved.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Approve'
    }).then((result)=>{

        if(result.isConfirmed){

            $.ajax({

                url: "{{ route('expense.status') }}",
                type: "POST",

                data:{
                    _token:"{{ csrf_token() }}",
                    id:id,
                    status:'approved'
                },

                success:function(res){

                    Swal.fire(
                        'Approved!',
                        res.message,
                        'success'
                    );

                    table.ajax.reload(null,false);
                }
            });

        }

    });

});
$(document).on('click','.rejectBtn',function(){

    let id = $(this).data('id');

    Swal.fire({
        title: 'Reject Expense?',
        text: 'This expense request will be rejected.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Reject',
        confirmButtonColor: '#dc3545'
    }).then((result)=>{

        if(result.isConfirmed){

            $.ajax({

                url: "{{ route('expense.status') }}",
                type: "POST",

                data:{
                    _token:"{{ csrf_token() }}",
                    id:id,
                    status:'rejected'
                },

                success:function(res){

                    Swal.fire(
                        'Rejected!',
                        res.message,
                        'success'
                    );

                    table.ajax.reload(null,false);
                }
            });

        }

    });

});
</script>      