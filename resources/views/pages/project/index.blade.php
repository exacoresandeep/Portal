<div class="content-wrapper p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1"> Project Management</h3>
        </div>
        <div>
            <button type="button"
            class="btn btn-success"
            id="exportBtn">
                <i class="bi bi-file-earmark-excel me-1"></i>
                Export
            </button>
            <button type="button"
            class="btn btn-primary"
            id="addProjectBtn">
            + Add Project

            </button> 
        </div>

    </div>
    <div class="mb-4">

        <div class="row g-3">

            <div class="col-md-3">

                <label class="form-label">
                    Year
                </label>

                <select
                    class="form-select"
                    id="year">

                    <option value="">
                        Select Year
                    </option>

                    @for($year = date('Y')+1; $year >= 2020; $year--)

                        <option value="{{ $year }}">
                            {{ $year }}
                        </option>

                    @endfor

                </select>

            </div>

            <div class="col-md-3">

                <label class="form-label">
                    Month
                </label>

                <select
                    class="form-select"
                    id="month">

                    <option value="">
                        Select Month
                    </option>

                    @for($month=1;$month<=12;$month++)

                        <option value="{{ $month }}">
                            {{ date('F', mktime(0,0,0,$month,1)) }}
                        </option>

                    @endfor

                </select>

            </div>

            <div class="col-md-3">

                <label class="form-label">
                    Status
                </label>

                <select
                    class="form-select"
                    id="status">

                    <option value="">
                        Select Status
                    </option>

                    <option value="Pending">
                        Pending
                    </option>

                    <option value="In Progress">
                        In Progress
                    </option>

                    <option value="Completed">
                        Completed
                    </option>

                </select>

            </div>

            <div class="col-md-3 d-flex align-items-end">

                <button
                    class="btn btn-primary w-100"
                    id="searchBtn">

                    Search

                </button>

            </div>

        </div>
  
    </div>


    <table
        id="projectTable" class="table table-striped table-hover align-middle w-100 data-table">

        <thead>

            <tr>

                <th>Sl No.</th>
                <th>Project</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Members</th>
                <th>Actions</th>

            </tr>

        </thead>

    </table>


</div>

{{-- Add Project Modal --}}
<div
    class="modal fade"
    id="projectModal"
    tabindex="-1">

    <div class="modal-dialog custom-modal">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Add Project
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <form id="projectForm">

                    @csrf
                    <input
                        type="hidden"
                        name="id"
                        id="project_id">
                    <div class="row g-3">

                        <div class="col-md-6">

                            <label class="form-label">
                                Project Name
                            </label>

                            <input
                                type="text"
                                name="project_name"
                                class="form-control">

                        </div>

                        <div class="col-md-3">

                            <label class="form-label">
                                Start Date
                            </label>

                            <input
                                type="date"
                                name="start_date"
                                class="form-control">

                        </div>

                        <div class="col-md-3">

                            <label class="form-label">
                                End Date
                            </label>

                            <input
                                type="date"
                                name="end_date"
                                class="form-control">

                        </div>

                        <div class="col-md-4">

                            <label class="form-label">
                                Status
                            </label>

                            <select
                                name="status"
                                class="form-select">

                                <option value="Pending">
                                    Pending
                                </option>

                                <option value="In Progress">
                                    In Progress
                                </option>

                                <option value="Completed">
                                    Completed
                                </option>

                            </select>

                        </div>

                        <div class="col-md-8">

                            <label class="form-label">
                                Description
                            </label>

                            <textarea
                                class="form-control"
                                name="description"
                                rows="2"></textarea>

                        </div>

                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-3">

                        <h6>
                            Team Members
                        </h6>

                        <button
                            type="button"
                            class="btn btn-sm btn-primary"
                            id="addMemberRow">

                            + Add Member

                        </button>

                    </div>

                    <table
                        class="table table-bordered">

                        <thead>

                            <tr>

                                <th width="45%">
                                    Employee
                                </th>

                                <th width="45%">
                                    Role
                                </th>

                                <th width="10%">
                                    Action
                                </th>

                            </tr>

                        </thead>

                        <tbody id="memberTableBody">

                        </tbody>

                    </table>

                </form>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                    Close

                </button>

                <button
                    type="button"
                    class="btn btn-primary"
                    id="saveProjectBtn">

                    Save Project

                </button>

            </div>

        </div>

    </div>

</div>


<div class="modal fade"
     id="viewProjectModal"
     tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="fw-bold mb-0">
                    Project Name:
                    <span id="projectName"></span>
                </h4>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <div class="row mb-4">

                    <div class="col-md-3">
                        <small class="text-muted">
                            Start Date
                        </small>

                        <div
                            class="fw-semibold"
                            id="projectStartDate">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted">
                            End Date
                        </small>

                        <div
                            class="fw-semibold"
                            id="projectEndDate">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted">
                            Status
                        </small>

                        <div
                            class="fw-semibold"
                            id="projectStatus">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted">
                            Members
                        </small>

                        <div
                            class="fw-semibold"
                            id="projectMembersCount">
                        </div>
                    </div>

                </div>

                <div class="row mb-4">

                    <div class="col-md-6">

                        <small class="text-muted">
                            Technology
                        </small>

                        <div
                            class="fw-semibold"
                            id="projectTechnology">
                        </div>

                    </div>

                </div>
                <hr>
                <h5 class="mb-3">
                    Project Members
                </h5>

                <table class="table table-striped table-hover align-middle w-100 data-table">

                    <thead>

                        <tr>

                            <th>Sl No.</th>
                            <th>Employee ID</th>
                            <th>Employee Name</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Role</th>

                        </tr>

                    </thead>

                    <tbody id="projectMembersBody">

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


<script>

var table = $('#projectTable').DataTable({

    processing:true,

    serverSide:true,

    ajax:{
        url:"{{ route('project.list') }}",

        data:function(d){

            d.year = $('#year').val();

            d.month = $('#month').val();

            d.status = $('#status').val();

        }
    },

    columns:[

        {
            data:'DT_RowIndex',
            searchable:false,
            orderable:false
        },

        {
            data:'project_name'
        },

        {
            data:'start_date'
        },

        {
            data:'end_date'
        },

        {
            data:'status'
        },

        {
            data:'members_count'
        },

        {
            data:'action',
            searchable:false,
            orderable:false
        }

    ]

});

$('#searchBtn').click(function(){

    table.ajax.reload();

});

$('#addProjectBtn').click(function(){

    $('#projectForm')[0].reset();

    $('#memberTableBody').html('');

    $('#projectModal').modal('show');

});

$('#addMemberRow').click(function(){

    let row = `
        <tr>

            <td>

                <select
                    name="employee_id[]"
                    class="form-select">

                    <option value="">
                        Select Employee
                    </option>

                    @foreach($employees as $employee)

                        <option value="{{ $employee->id }}">
                            {{ $employee->name }}
                        </option>

                    @endforeach

                </select>

            </td>

            <td>

                <input
                    type="text"
                    name="role[]"
                    class="form-control">

            </td>

            <td>

                <button
                    type="button"
                    class="btn btn-danger removeRow">

                    X

                </button>

            </td>

        </tr>
    `;

    $('#memberTableBody').append(row);

});

$(document).on(
    'click',
    '.removeRow',
    function(){

        $(this)
            .closest('tr')
            .remove();

    }
);

$('#saveProjectBtn').click(function(){

    $.ajax({

        url:"{{ route('project.store') }}",

        type:"POST",

        data:$('#projectForm').serialize(),

        success:function(res){

            if(res.status){

                $('#projectModal')
                    .modal('hide');

                 table.ajax.reload();

                Swal.fire(
                    'Success',
                    res.message,
                    'success'
                );

            }

        }

    });

});

$(document).on(
    'click',
    '.viewBtn',
    function(){

        let id =
            $(this).data('id');

        $.get(
            "{{ url('project-view') }}/"+id,

            function(res){

                $('#projectName')
                    .text(
                        res.project.project_name
                    );

                $('#projectStartDate')
                    .text(
                        formatDate(
                            res.project.start_date
                        )
                    );

                $('#projectEndDate')
                    .text(
                        formatDate(
                            res.project.end_date
                        )
                    );

                $('#projectStatus')
                    .text(
                        res.project.status
                    );

                $('#projectMembersCount')
                    .text(
                        res.members.length
                    );

                $('#projectTechnology')
                    .text(
                        res.project.description ?? '-'
                    );

                let html = '';

                $.each(
                    res.members,
                    function(index,row){

                        html += `
                            <tr>

                                <td>
                                    ${row.slno}
                                </td>

                                <td>
                                    ${row.employee_id}
                                </td>

                                <td>
                                    ${row.employee_name}
                                </td>

                                <td>
                                    ${row.department}
                                </td>

                                <td>
                                    ${row.designation}
                                </td>

                                <td>
                                    ${row.role}
                                </td>

                            </tr>
                        `;
                    }
                );

                $('#projectMembersBody')
                    .html(html);

                new bootstrap.Modal(
                    document.getElementById(
                        'viewProjectModal'
                    )
                ).show();

            }
        );

    }
);

function formatDate(dateString)
{
    let date = new Date(dateString);

    return String(
        date.getDate()
    ).padStart(2,'0')
    + '-'
    + String(
        date.getMonth()+1
    ).padStart(2,'0')
    + '-'
    + date.getFullYear();
}

$(document).on(
    'click',
    '.editBtn',
    function(){

        let id = $(this).data('id');

        $.get(
            "{{ url('project-edit') }}/"+id,
            function(res){

                $('#project_id')
                    .val(res.id);

                $('input[name="project_name"]')
                    .val(res.project_name);

                // $('input[name="start_date"]')
                //     .val(res.start_date);

                // $('input[name="end_date"]')
                //     .val(res.end_date);

                $('input[name="start_date"]').val(
                    res.start_date.split('T')[0]
                );

                $('input[name="end_date"]').val(
                    res.end_date.split('T')[0]
                );
                $('select[name="status"]')
                    .val(res.status);

                $('textarea[name="description"]')
                    .val(res.description);

                $('#memberTableBody').html('');

                $.each(
                    res.team_members,
                    function(employeeId, role){

                        let row = `
                            <tr>

                                <td>

                                    <select
                                        name="employee_id[]"
                                        class="form-select">

                                        @foreach($employees as $employee)

                                            <option
                                                value="{{ $employee->id }}"
                                                ${employeeId == "{{ $employee->id }}" ? 'selected' : ''}>

                                                {{ $employee->name }}

                                            </option>

                                        @endforeach

                                    </select>

                                </td>

                                <td>

                                    <input
                                        type="text"
                                        class="form-control"
                                        name="role[]"
                                        value="${role}">

                                </td>

                                <td>

                                    <button
                                        type="button"
                                        class="btn btn-danger removeRow">

                                        X

                                    </button>

                                </td>

                            </tr>
                        `;

                        $('#memberTableBody')
                            .append(row);

                    }
                );

                $('#projectModal').modal('show');

            }
        );

    }
);

$('#exportBtn').click(function(){

    let year = $('#year').val();

    let month = $('#month').val();

    let status = $('#status').val();

    let url =
        "{{ route('project.export') }}" +
        '?year=' + year +
        '&month=' + month +
        '&status=' + status;

    window.location.href = url;

});
</script>
