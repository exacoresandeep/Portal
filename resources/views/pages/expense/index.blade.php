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
            <button class="btn btn-primary" id="addExpenseBtn">
                <i class="bi bi-plus-lg me-1"></i>
                Create Expense
            </button>
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


<div class="modal fade" id="expenseModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <form id="expenseForm" enctype="multipart/form-data">

                @csrf

                <div class="modal-header border-0">
                    <div>
                        <h4 class="fw-bold mb-0">
                            Create Expense Request
                        </h4>

                        <small class="text-muted">
                            Submit your expense request for approval
                        </small>
                    </div>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">

                    <hr>

                    <h6 class="fw-bold mb-3">
                        Expense Information
                    </h6>

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Expense Date
                            </label>

                            <input
                                type="date"
                                name="expense_date"
                                class="form-control"
                                max="{{ date('Y-m-d') }}"
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Amount
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="1"
                                name="amount"
                                class="form-control"
                                placeholder="Enter Amount"
                                required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">
                                Purpose
                            </label>

                            <textarea
                                name="purpose"
                                rows="3"
                                class="form-control"
                                placeholder="Expense purpose"
                                required></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Expense Bill
                            </label>

                            <input
                                type="file"
                                name="document"
                                class="form-control"
                                required>
                        </div>

                    </div>

                </div>

                <div class="modal-footer border-0">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary">
                        Submit
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
$('#addExpenseBtn').click(function () {

    $('#expenseForm')[0].reset();

    $('#expenseModal').modal('show');

});
$(document).on('click', '.deleteExpense', function () {

    let btn = $(this);
    let id = btn.data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "This Expense request will be removed permanently.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Remove',
        cancelButtonText: 'Cancel'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: "{{ route('expense.delete') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function (response) {

                    if (response.status) {

                        $('#expenseTable').DataTable().ajax.reload(null, false);

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

$('#expenseForm').submit(function(e){

    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({

        url:"{{ route('expense.store') }}",

        type:"POST",

        data:formData,

        processData:false,

        contentType:false,

        success:function(res){

            $('#expenseModal').modal('hide');

            Swal.fire(
                'Success',
                res.message,
                'success'
            );

            table.ajax.reload(null,false);

        },

        error:function(xhr){

            let errors = xhr.responseJSON.errors;

            let message='';

            $.each(errors,function(k,v){

                message+=v[0]+'<br>';

            });

            Swal.fire(
                'Validation Error',
                message,
                'error'
            );

        }

    });

});
$(document).on('click', '.view-image', function () {

    $('#previewFrame').attr('src', $(this).data('image'));

    let modal = new bootstrap.Modal(document.getElementById('fileModal'));
    modal.show();
});
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