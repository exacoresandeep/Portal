<div class="content-wrapper p-4">

    <div class="d-flex justify-content-between mb-4">

        <h4 class="fw-bold">
            Evaluation Schedule
        </h4>

        <button
            type="button"
            class="btn btn-primary"
            id="assignFormBtn">
            + Assign Form
        </button>

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
                <div class="col-md-2">
                    <label class="form-label">Quater</label>
                    <select name="year" class="form-select" id="quater">
                            <option value="">Select</option>
                            <option value="First Quarter">First Quater</option>
                            <option value="Second Quarter">Second Quater</option>
                            <option value="Third Quarter">Third Quater</option>
                            <option value="Fourth Quarter">Fourth Quater</option>
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

            <table
                id="evaluationTable"
                class="table table-striped table-hover align-middle w-100 data-table">

                <thead>

                    <tr>

                        <th>Sl No.</th>
                        <th>Form Name</th>
                        <th>Department</th>
                        <th>Year</th>
                        <th>Quater</th>
                        <th>Total Score</th>
                        <th>End Date</th>
                        <th>Actions</th>

                    </tr>

                </thead>

            </table>

</div>


<div class="modal fade"
     id="assignFormModal"
     tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Assign Evaluation Form</h3>      
                </div>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>              
            </div>

            <div class="modal-body">
                <form id="assignForm">
                    <input
                        type="hidden"
                        name="id"
                        id="form_id">
                    <div class="container-fluid">
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Year</label>
                                <select name="year" class="form-select" >
                                    @for($year = date('Y') + 1; $year >= 2020; $year--)
                                        <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Quater</label>
                                <select class="form-select" name="quater">
                                        <option value="">Select</option>
                                        <option value="First Quarter">First Quater</option>
                                        <option value="Second Quarter">Second Quater</option>
                                        <option value="Third Quarter">Third Quater</option>
                                        <option value="Fourth Quarter">Fourth Quater</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Department</label>

                                <select class="form-select" name="department">
                                    <option  value=""  selected>Select</option>
                                    @foreach($departments as $department)

                                        <option value="{{ $department->id }}">

                                            {{ $department->name }}

                                        </option>

                                    @endforeach

                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Form</label>

                                <select class="form-select" name="evaluation_id">
                                    <option  value=""  selected>Select</option>
                                    @foreach($evaluation_forms as $evaluation_form)

                                        <option value="{{ $evaluation_form->id }}">

                                            {{ $evaluation_form->name }}

                                        </option>

                                    @endforeach

                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">End Date</label>
                                <input type="date" name="enddate" class="form-select">
                            </div>
                        </div> 
                        <div class="mt-4">
                            <button type="button" class="btn btn-outline-dark" style="width: 120px;" onclick="cancelForm()">
                                Cancel
                            </button>
                            <button type="button" class="btn btn-primary ms-2" style="width: 120px;" onclick="submitForm()">
                                Submit
                            </button>
                        </div>                       
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewScheduleModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="viewTitle">View Evaluation Schedule</h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">

                <div class="row mb-4">

                    

                    <div class="col-md-3">
                        <small class="text-muted">Department</small>
                        <div id="viewDepartment"></div>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted">Year</small>
                        <div id="viewYear"></div>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted">Quarter</small>
                        <div id="viewQuarter"></div>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted">End Date</small>
                        <div id="viewEndDate"></div>
                    </div>

                </div>

                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th width="5%">Sl No</th>
                            <th width="25%">Evaluation Criteria</th>
                            <th width="55%">Sub Points</th>
                            <th width="15%">Total Score</th>
                        </tr>
                    </thead>

                    <tbody id="criteriaTableBody"></tbody>

                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">
                                Total Points
                            </th>

                            <th id="grandTotal"></th>
                        </tr>
                    </tfoot>

                </table>

            </div>

        </div>
    </div>
</div>


<script>

    $(document).on(
    'click',
    '.viewBtn',
    function () {

        let id = $(this).data('id');

        $.get(
            "{{ url('evaluation-schedule-view') }}/" + id,
            function (res) {
                $('#viewTitle').text("Form : "+res.form.name);

                $('#viewFormName').text(
                    res.form.name
                );

                $('#viewDepartment').text(
                    res.department.name
                );

                $('#viewYear').text(
                    res.year
                );
                $('#viewQuarter').text(
                    res.quarter
                );

                let date = new Date(res.end_date);

                let formattedDate =
                    ('0' + date.getDate()).slice(-2) + '-' +
                    ('0' + (date.getMonth() + 1)).slice(-2) + '-' +
                    date.getFullYear();

                $('#viewEndDate').text(formattedDate);

                let html = '';

                let total = 0;

                $.each(
                    res.form.questions,
                    function(index, question){

                        total += parseInt(question.marks);

                        let subpoints = '';

                        if(question.subpoints){

                            let points = JSON.parse(question.subpoints);

                            subpoints = '<ul class="mb-0">';

                            $.each(points, function(i, item){

                                subpoints += '<li>' + item + '</li>';

                            });

                            subpoints += '</ul>';
                        }

                        html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${question.question}</td>
                                <td>${subpoints}</td>
                                <td>${question.marks}</td>
                            </tr>
                        `;
                    }
                );

                $('#criteriaTableBody').html(
                    html
                );

                $('#grandTotal').text(
                    total
                );

               $('#viewScheduleModal').modal(
                    'show'
                ); 
            }
        );
    }
);

$(document).on('click', '.deleteBtn', function () {

    let id = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: 'This will delete the schedule and related assignments.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Delete'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: "{{ url('evaluation-schedule-delete') }}/" + id,
                type: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {

                    Swal.fire(
                        'Deleted!',
                        response.message,
                        'success'
                    );

                    table.ajax.reload();
                },
                error: function () {

                    Swal.fire(
                        'Error',
                        'Unable to delete schedule.',
                        'error'
                    );
                }
            });

        }

    });

});
    var table = $('#evaluationTable').DataTable({

        processing: true,
        serverSide: true,

        ajax: {
            url: "{{ route('evaluation.schedule.list') }}",
            data: function (d) {

                d.year = $('#year').val();
                d.quater = $('#quater').val();
                d.department_id = $('#department_id').val();

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
                data: 'form_name',
                name: 'form_name'
            },

            {
                data: 'department_name',
                name: 'department_name'
            },

            {
                data: 'year',
                name: 'year'
            },

            {
                data: 'quarter',
                name: 'quarter'
            },

            {
                data: 'total_score',
                name: 'total_score'
            },

            {
                data: 'end_date',
                name: 'end_date'
            },

            {
                data: 'action',
                name: 'action',
                searchable: false,
                orderable: false
            }

        ]
    });
$('#assignFormBtn').click(function(){
        $('#assignForm')[0].reset();
        $('#form_id').val('');
        $('#modalTitle').text(
            'Add Evaluation Form'
        );
        $('#assignFormModal').modal('show');
    });

$('#searchBtn').click(function (e) {

    e.preventDefault();

    table.ajax.reload();

});
function submitForm()
{
    $.ajax({
        url: "{{ route('evaluation.assign.store') }}",
        type: "POST",
        data: $('#assignForm').serialize(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {

            $('.btn-primary').prop('disabled', true);

        },
        success: function (response) {

            $('.btn-primary').prop('disabled', false);

            if (response.status) {

                $('#assignFormModal').modal('hide');

                $('#assignForm')[0].reset();

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message
                });

                table.ajax.reload();

            } else {

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });

            }
        },
        error: function (xhr) {

            $('.btn-primary').prop('disabled', false);

            let message = 'Something went wrong';

            if (xhr.responseJSON?.message) {

                message = xhr.responseJSON.message;

            }

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message
            });
        }
    });
}
</script>