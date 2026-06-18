<div class="content-wrapper p-3">
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">Learning And Development</h3>
        </div>

        <div>
            <button
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#assignTraineeModal">
                <i class="bi bi-plus-lg me-1"></i> Assign Trainee
            </button>
        </div>

    </div>
   

    <!-- Filter -->
    <div class="row mb-4">
        <div class="col-md-3">
            <select class="form-select" id="department_id">

                <option selected>
                    Select Department
                </option>

                @foreach($departments as $department)

                    <option value="{{ $department->id }}">
                        {{ $department->name }}
                    </option>

                @endforeach

            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary w-100" id="filterBtn">
                Search
            </button>
        </div>
    </div>

   

    <!-- Table -->
     <div class="table-responsive">

        <table class="table table-striped table-hover align-middle w-100 data-table" id="assignTable">
            <thead class="table-light">
                <tr>
                    <th width="80">Sl No.</th>
                    <th>Trainee</th>
                    <th>Trainer</th>
                    <th>Assigned Date</th>
                    <th>Status</th>
                    <th>HR Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                
            </tbody>
        </table>
    </div>

</div>

<div class="modal fade" id="assignTraineeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">
                        Assign Trainer To Trainee
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <!-- Trainer -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Trainer
                            </label>

                            <select
                                name="trainer_id" id="trainer_id"
                                class="form-select"
                                required>
                                <option value="">
                                    Select Trainer
                                </option>

                                @foreach($trainers as $trainer)
                                    <option value="{{ $trainer->id }}">
                                        {{ $trainer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Trainee -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Trainee
                            </label>

                            <select
                                name="trainee_id" id="trainee_id"
                                class="form-select"
                                required>
                                <option value="">
                                    Select Trainee
                                </option>

                                @foreach($trainees as $trainee)
                                    <option value="{{ $trainee->id }}">
                                        {{ $trainee->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Assigned Date
                            </label>

                            <input
                                type="date" id="assigned_date"
                                name="assigned_date"
                                class="form-control"
                                value="">
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Close
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary" id="assignBtn">
                        Assign
                    </button>
                </div>

           

        </div>
    </div>
</div>


<div class="modal fade" id="viewModal">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">
                <h5>Training & Development Details</h5>

                <button class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">

                <div id="viewContent"></div>

            </div>

        </div>

    </div>

</div>

<div class="modal fade" id="phaseReviewModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Phase HR Review</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="hidden" id="review_row_id">

                <div class="mb-2">
                    <label>Phase</label>
                    <input type="text" id="review_phase" class="form-control" readonly>
                </div>

                <div class="mb-2">
                    <label>HR Status</label>
                    <select id="review_hr_status" class="form-select">
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label>HR Remark</label>
                    <textarea id="review_hr_remark" class="form-control"></textarea>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" id="savePhaseReview">Save</button>
            </div>

        </div>
    </div>
</div>
<script>
    

    $('#savePhaseReview').click(function () {

    let id = $('#review_row_id').val();

    $.ajax({
        url: '/training/phase-hr-review/' + id,
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            hr_status: $('#review_hr_status').val(),
            hr_remark: $('#review_hr_remark').val()
        },
        success: function (res) {

            $('#phaseReviewModal').modal('hide');
            $('#reviewModal').modal('hide');

                Swal.fire({
                    icon: 'success',
                    title: 'Updated',
                    text: res.message
                }).then(() => {

                    // reopen view modal again
                    $('.viewBtn[data-id="'+currentViewId+'"]').trigger('click');
                });

            $('#assignTable').DataTable().ajax.reload();
        }
    });

});
    $(document).on('click', '.reviewPhaseBtn', function () {

    $('#review_row_id').val($(this).data('id'));
    $('#review_phase').val($(this).data('phase'));
    $('#review_hr_status').val($(this).data('hr_status'));
    $('#review_hr_remark').val($(this).data('hr_remark'));

    $('#phaseReviewModal').modal('show');
});
var currentViewId = null;
$(document).on('click', '.viewBtn', function () {

    currentViewId = $(this).data('id');

    let id = currentViewId;

    $.get('/training/view/' + id, function (res) {

        let html = '';

        let trainee = '';
        let trainer = '';
        let assignedDate = '';

        if (res.length > 0) {

            trainee = res[0].trainee_name ?? '-';
            trainer = res[0].trainer_name ?? '-';
            assignedDate = res[0].assigned_date ?? '-';
        }

        $.each(res, function (index, row) {

            html += `
                <tr>
                    <td>${row.phase_name ?? '-'}</td>
                    <td>
                        <span class="badge ${
                            row.status === 'completed'
                            ? 'bg-success'
                            : 'bg-warning'
                        }">
                            ${row.status}
                        </span>
                    </td>
                    <td>
                        <span class="badge ${
                            row.hr_status === 'completed'
                            ? 'bg-success'
                            : 'bg-warning'
                        }">
                            ${row.hr_status}
                        </span>
                    </td>
                    <td>${row.hr_remark ?? '-'}</td>
                    <td>
                        ${
                            row.status === 'completed'
                            ? `
                                <button class="btn btn-sm btn-warning reviewPhaseBtn"
                                    data-id="${row.id}"
                                    data-phase="${row.phase_name}"
                                    data-hr_status="${row.hr_status}"
                                    data-hr_remark="${row.hr_remark ?? ''}">
                                    Review
                                </button>
                            `
                            : `
                                <span class="text-muted">Not Allowed</span>
                            `
                        }
                    </td>
                </tr>
            `;
        });

        $('#viewContent').html(`

            <div class="row mb-3">

                <div class="col-md-4">
                    <strong>Trainee :</strong><br>
                    ${trainee}
                </div>

                <div class="col-md-4">
                    <strong>Trainer :</strong><br>
                    ${trainer}
                </div>

                <div class="col-md-4">
                    <strong>Assigned Date :</strong><br>
                    ${assignedDate}
                </div>

            </div>

            <table class="table table-bordered">

                <thead class="table-light">
                    <tr>
                        <th>Phase Name</th>
                        <th>Status</th>
                        <th>HR Status</th>
                        <th>HR Remark</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    ${html}
                </tbody>

            </table>

        `);

        $('#viewModal').modal('show');

    });

});

$(document).on('click','.deleteBtn',function(){

    let id = $(this).data('id');

    Swal.fire({
        title: 'Delete Assignment?',
        text: 'All assigned phases will be removed.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete'
    }).then((result)=>{

        if(result.isConfirmed){

            $.ajax({

                url:'/training/delete/' + id,

                type:'DELETE',

                headers:{
                    'X-CSRF-TOKEN':
                    $('meta[name="csrf-token"]').attr('content')
                },

                success:function(response){

                    Swal.fire({
                        icon:'success',
                        title:'Deleted',
                        text:response.message
                    });

                    $('#assignTable')
                        .DataTable()
                        .ajax
                        .reload();
                }
            });

        }

    });

});


$('#filterBtn').click(function () {
    $('#assignTable').DataTable().ajax.reload();
});
$(document).ready(function () {

    loadTable();

    $('#assignBtn').click(function () {

    let trainer_id = $('#trainer_id').val();
    let trainee_id = $('#trainee_id').val();
    let assigned_date = $('#assigned_date').val();

    if (!trainer_id || !trainee_id) {

        Swal.fire({
            icon: 'warning',
            title: 'Required',
            text: 'Please select Trainer and Trainee.'
        });

        return;
    }

    Swal.fire({
        title: 'Assign Trainee?',
        text: 'All department training phases will be assigned.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Assign',
        cancelButtonText: 'Cancel'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: "{{ route('training.assign') }}",
                type: "POST",

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                data: {
                    trainer_id: trainer_id,
                    trainee_id: trainee_id,
                    assigned_date: assigned_date
                },

                success: function (response) {

                    $('#assignTraineeModal').modal('hide');

                    $('#assignTable').DataTable().ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        title: 'Assigned!',
                        text: response.message
                    });
                },

                error: function (xhr) {

                    let errors = '';

                    if (xhr.status === 422) {

                        $.each(xhr.responseJSON.errors, function (key, value) {
                            errors += value[0] + '<br>';
                        });
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: errors || 'Something went wrong'
                    });
                }
            });

        }
    });
});

});


function loadTable()
{
    $('#assignTable').DataTable({

        processing: true,
        serverSide: true,
        destroy: true,

        ajax: {
            url: "{{ route('training.assign.list') }}",
            data: function (d) {

                d.department_id = $('#department_id').val();
            }
        },

        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                searchable:false,
                orderable:false
            },
            {
                data:'trainee',
                name:'trainee'
            },
            {
                data:'trainer',
                name:'trainer'
            },
            {
                data:'assigned_date',
                name:'assigned_date'
            },
            {
                data:'status',
                name:'status'
            },
            {
                data:'hr_status',
                name:'hr_status'
            },
            {
                data:'action',
                name:'action',
                searchable:false,
                orderable:false
            }
        ]
    });
}
</script>