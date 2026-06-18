<div class="content-wrapper p-3">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">Leave Counts</h3>
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
                    <label class="form-label">Department</label>

                    <select class="form-select"  id="department_id">
                        <option  value=""  selected>Select</option>
                        @foreach($departments as $department)

                            <option value="{{ $department->id }}">

                                {{ $department->name }}

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
                <th>Department</th>
                <th>Year</th>
                <th>Total Leave</th>
                <th>Used Leave</th>
                <th>Balance Leave</th>
                <th>Sick Leave</th>
                <th>Casual Leave</th>
                <th>Earned Leave</th>
            </tr>
        </thead>

    </table>
</div>



<script>
    $('#exportBtn').click(function () {

        let year = $('#year').val();
        let department = $('#department_id').val();

        let url = "{{ route('leavecount.export') }}"
            + "?year=" + year
            + "&department_id=" + department;

        window.location.href = url;
    });

var table = $('#wfhTable').DataTable({

    processing: true,
    serverSide: true,

    ajax: {
        url: "{{ route('leavecount.list') }}",
        data: function (d) {
            d.year = $('#year').val();
            d.department_id = $('#department_id').val();
        }
    },

    columns: [
            { data:'DT_RowIndex', name:'DT_RowIndex', orderable:false, searchable:false },
            { data:'employee_name', name:'employee_name' },
            { data:'employee_id', name:'employee_id' },
            { data:'department', name:'department' },
            { data:'year', name:'year' },
            { data:'total_leave', name:'total_leave' },
            { data:'used_leave', name:'used_leave' },
            { data:'balance_leave', name:'balance_leave' },
            { data:'sick_leave', name:'sick_leave' },
            { data:'casual_leave', name:'casual_leave' },
            { data:'earned_leave', name:'earned_leave'}
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