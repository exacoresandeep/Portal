<div class="content-wrapper p-3">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Work Schedule Configuration</h3>
        </div>
        <div class="d-flex justify-content-end mb-3">
        @if(in_array(Auth::user()->department_id, [1, 2]))
            <button
                id="openAddHolidayModal"
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#addHolidayModal">
                Add Holiday
            </button>
        @endif   
        </div>
    </div>    

        <table class="table table-striped table-hover align-middle w-100 data-table"
        id="calenderTable">
            <thead>
            <tr>
                <th>Sl No.</th>
                <th>Year</th>
                <th>Project</th>
                <th>Actions</th>
            </tr>
            </thead>

            <tbody>

            @foreach($calendars as $calendar)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $calendar->year }}</td>

                    <td>{{ $calendar->project->name ?? '' }}</td>

                    <td>

                        <button
                            class="btn btn-sm btn-info viewBtn"
                            data-id="{{ $calendar->id }}">
                            View
                        </button>

                    </td>

                </tr>

            @endforeach

            </tbody>
        </table>

    
</div>

<div class="modal fade" id="addHolidayModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form id="holidayForm">

                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Add Holiday Calendar</h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Year <span class="text-danger">*</span>
                            </label>

                            <select
                                name="year"
                                class="form-select"
                                required>

                                <option value="">
                                    Select Year
                                </option>

                                @for($year = date('Y'); $year <= date('Y') + 5; $year++)
                                    <option value="{{ $year }}">
                                        {{ $year }}
                                    </option>
                                @endfor

                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Project <span class="text-danger">*</span>
                            </label>

                            <select
                                name="project_id"
                                class="form-select"
                                required>

                                <option value="">
                                    Select Project
                                </option>

                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}">
                                        {{ $project->project_name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                        <input
                            type="hidden"
                            id="holidayId"
                            name="holiday_id">

                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <h6 class="mb-0">
                            Holiday Details
                        </h6>

                        

                    </div>

                    <div id="holidayRows">

                        <div class="row holiday-row mb-3">

                            <div class="col-md-5">

                                <label class="form-label">
                                    Holiday Date
                                </label>

                                <input
                                    type="date"
                                    name="holiday_date[]"
                                    class="form-control"
                                    required>

                            </div>

                            <div class="col-md-5">

                                <label class="form-label">
                                    Description
                                </label>

                                <input
                                    type="text"
                                    name="description[]"
                                    class="form-control"
                                    placeholder="Enter holiday description"
                                    required>

                            </div>

                            <div class="col-md-2">

                                <label class="form-label d-block">
                                    &nbsp;
                                </label>

                                <button
                                    type="button"
                                    class="btn btn-danger removeRow w-20">

                                    <i class="bi bi-icon bi-trash"></i>

                                </button>

                            </div>

                        </div>
                        
                    </div>
                    <button
                        type="button"
                        class="btn btn-success btn-sm"
                        id="addHolidayRow">

                        <i class="fa fa-plus"></i> Add Row

                    </button>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        Add Holiday

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<div class="modal fade" id="viewHolidayModal" tabindex="-1">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Holiday Calendar Details
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <div class="row mb-4">

                    <div class="col-md-6">
                        <strong>Project :</strong>
                        <span id="viewProject"></span>
                    </div>

                    <div class="col-md-6">
                        <strong>Year :</strong>
                        <span id="viewYear"></span>
                    </div>

                </div>

                <!-- Tabs -->

                <ul class="nav nav-tabs" id="holidayTabs" role="tablist">

                    <li class="nav-item" role="presentation">

                        <button
                            class="nav-link active"
                            id="holiday-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#holiday-pane"
                            type="button">

                            Holiday List

                        </button>

                    </li>

                    <li class="nav-item" role="presentation">

                        <button
                            class="nav-link"
                            id="employee-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#employee-pane"
                            type="button">

                            Employee List

                        </button>

                    </li>

                </ul>

                <!-- Tab Contents -->

                <div class="tab-content pt-3">

                    <!-- Holiday Tab -->

                    <div
                        class="tab-pane fade show active"
                        id="holiday-pane">

                        <table class="table table-bordered table-striped">

                            <thead>

                                <tr>
                                    <th width="60">#</th>
                                    <th width="150">Date</th>
                                    <th>Description</th>
                                </tr>

                            </thead>

                            <tbody id="viewHolidayBody">

                            </tbody>

                        </table>

                    </div>

                    <!-- Employee Tab -->

                    <div
                        class="tab-pane fade"
                        id="employee-pane">

                        <table class="table table-bordered table-striped">

                            <thead>

                                <tr>
                                    <th width="60">#</th>
                                    <th>Employee ID</th>
                                    <th>Employee Name</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                </tr>

                            </thead>

                            <tbody id="employeeBody">

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
<script>
function resetHolidayForm()
{
    $('#holidayForm')[0].reset();

    $('#holidayId').val('');

    $('#holidayRows').html(`
        <div class="row holiday-row mb-3">

            <div class="col-md-5">
                <label class="form-label">Holiday Date</label>
                <input
                    type="date"
                    name="holiday_date[]"
                    class="form-control"
                    required>
            </div>

            <div class="col-md-5">
                <label class="form-label">Description</label>
                <input
                    type="text"
                    name="description[]"
                    class="form-control"
                    placeholder="Enter holiday description"
                    required>
            </div>

            <div class="col-md-2">
                <label class="form-label d-block">&nbsp;</label>
                <button
                    type="button"
                    class="btn btn-danger removeRow w-20">
                    <i class="bi bi-trash"></i>
                </button>
            </div>

        </div>
    `);

    $('.modal-title').text('Add Holiday Calendar');

    $('.saveHolidayBtn').text('Save');
}
$(document).on(
    'click',
    '#openAddHolidayModal',
    function(){

        resetHolidayForm();

    }
);
$(function () {

    $('#calenderTable').DataTable({

        processing: true,

        serverSide: true,

        ajax: "{{ route('calendar.list') }}",

        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'year',
                name: 'year'
            },
            {
                data: 'project_name',
                name: 'project.name'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ],

        pageLength: 10,

        responsive: true

    });

});
$(document).on('click', '#addHolidayRow', function () {

    let year = $('select[name="year"]').val();

    let minDate = '';
    let maxDate = '';

    if(year){
        minDate = year + '-01-01';
        maxDate = year + '-12-31';
    }

    let row = `
        <div class="row holiday-row mb-3">

            <div class="col-md-5">
                <input
                    type="date"
                    name="holiday_date[]"
                    class="form-control"
                    min="${minDate}"
                    max="${maxDate}"
                    required>
            </div>

            <div class="col-md-5">
                <input
                    type="text"
                    name="description[]"
                    class="form-control"
                    placeholder="Enter holiday description"
                    required>
            </div>

            <div class="col-md-2">
                <button
                    type="button"
                    class="btn btn-danger removeRow w-20">
                    <i class="bi bi-icon bi-trash"></i>
                </button>
            </div>

        </div>
    `;

    $('#holidayRows').append(row);

});

$(document).on('click', '.removeRow', function () {

    if ($('.holiday-row').length > 1) {

        $(this).closest('.holiday-row').remove();

    } else {

        Swal.fire({
            icon: 'warning',
            title: 'Warning',
            text: 'At least one holiday row is required.'
        });

    }

});

$(document).on('change', 'select[name="year"]', function () {

    let year = $(this).val();

    if(year){

        let minDate = year + '-01-01';
        let maxDate = year + '-12-31';

        $('input[name="holiday_date[]"]').each(function(){

            $(this).attr('min', minDate);
            $(this).attr('max', maxDate);

            // Clear invalid existing value
            let currentDate = $(this).val();

            if(currentDate){
                let selectedYear = currentDate.split('-')[0];

                if(selectedYear != year){
                    $(this).val('');
                }
            }

        });

    }

});

$('#holidayForm').submit(function(e){

    e.preventDefault();

    $.ajax({

        url: "{{ route('calendar.store') }}",

        type: "POST",

        data: $(this).serialize(),

        beforeSend: function(){

            $('.saveHolidayBtn').prop(
                'disabled',
                true
            );

        },

        success: function(response){

            $('#addHolidayModal').modal('hide');

            resetHolidayForm();

            $('#holidayRows').html(`
                <div class="row holiday-row mb-3">

                    <div class="col-md-4">
                        <input
                            type="date"
                            name="holiday_date[]"
                            class="form-control"
                            required>
                    </div>

                    <div class="col-md-6">
                        <input
                            type="text"
                            name="description[]"
                            class="form-control"
                            placeholder="Enter holiday description"
                            required>
                    </div>

                    <div class="col-md-2">
                        <button
                            type="button"
                            class="btn btn-danger removeRow w-20">
                            <i class="bi bi-icon bi-trash"></i>
                        </button>
                    </div>

                </div>
            `);

            $('#calenderTable')
                .DataTable()
                .ajax
                .reload();

            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: response.message,
                timer: 2000,
                showConfirmButton: false
            });

        },

        error: function(xhr){

            let message =
                'Something went wrong';

            if(
                xhr.responseJSON &&
                xhr.responseJSON.message
            ){
                message =
                    xhr.responseJSON.message;
            }

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message
            });
        },

        complete: function(){

            $('.saveHolidayBtn').prop(
                'disabled',
                false
            );

        }

    });

});

$(document).on(
    'click',
    '.viewBtn',
    function(){

        let id = $(this).data('id');

        $.get(
            "{{ url('calendar') }}/"+id,
            function(res){

                let data = res.data;

                $('#viewProject').text(
                    data.project.project_name
                );

                $('#viewYear').text(
                    data.year
                );

                
                $('#viewHolidayBody').empty();
                $('#employeeBody').empty();

                // Holidays

                $.each(res.data.holidays, function(index,row){

                    $('#viewHolidayBody').append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${row.date}</td>
                            <td>${row.description}</td>
                        </tr>
                    `);

                });

                // Employees

                if(res.employees.length > 0){

                    $.each(res.employees, function(index,row){

                        $('#employeeBody').append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${row.emp_id ?? row.employee_id ?? '-'}</td>
                                <td>${row.employee_name ?? row.name ?? '-'}</td>
                                <td>${row.department.name ?? '-'}</td>
                                <td>${row.designation.name ?? '-'}</td>
                            </tr>
                        `);

                    });

                }else{

                    $('#employeeBody').html(`
                        <tr>
                            <td colspan="5" class="text-center">
                                No Employees Assigned
                            </td>
                        </tr>
                    `);

                }

                // Always open Holidays tab first

                $('.nav-tabs button:first').tab('show');
                $('#viewHolidayModal').modal('show');

            }
        );

    }
);

$('#addHolidayModal').on(
    'hidden.bs.modal',
    function(){

        resetHolidayForm();

    }
);
$(document).on(
    'click',
    '.editBtn',
    function(){

        resetHolidayForm();

        let id = $(this).data('id');

        $.get(
            "{{ url('calendar/edit') }}/"+id,
            function(res){

                let data = res.data;

                $('#holidayId').val(data.id);

                $('select[name="year"]').val(data.year);

                $('select[name="project_id"]').val(data.project_id);

                $('.modal-title').text(
                    'Edit Holiday Calendar'
                );

                $('.saveHolidayBtn').text(
                    'Update'
                );

                // VERY IMPORTANT
                $('#holidayRows').empty();

                $.each(
                    data.holidays,
                    function(index,row){

                        $('#holidayRows').append(`
                            <div class="row holiday-row mb-3">

                                <div class="col-md-5">
                                    <input
                                        type="date"
                                        name="holiday_date[]"
                                        value="${row.date}"
                                        class="form-control"
                                        required>
                                </div>

                                <div class="col-md-5">
                                    <input
                                        type="text"
                                        name="description[]"
                                        value="${row.description}"
                                        class="form-control"
                                        required>
                                </div>

                                <div class="col-md-2">
                                    <button
                                        type="button"
                                        class="btn btn-danger removeRow w-20">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                            </div>
                        `);

                    }
                );

                $('#addHolidayModal').modal('show');

            }
        );

    }
);

$(document).on(
    'click',
    '.deleteBtn',
    function(){

        let id = $(this).data('id');

        Swal.fire({

            title: 'Delete Holiday Calendar?',

            text: 'This action cannot be undone.',

            icon: 'warning',

            showCancelButton: true,

            confirmButtonText: 'Delete'

        }).then((result)=>{

            if(result.isConfirmed){

                $.ajax({

                    url:
                    "{{ url('calendar/delete') }}/"+id,

                    type:'DELETE',

                    data:{
                        _token:
                        "{{ csrf_token() }}"
                    },

                    success:function(res){

                        Swal.fire(
                            'Deleted!',
                            res.message,
                            'success'
                        );

                        $('#calenderTable')
                            .DataTable()
                            .ajax.reload();

                    }

                });

            }

        });

    }
);
</script>