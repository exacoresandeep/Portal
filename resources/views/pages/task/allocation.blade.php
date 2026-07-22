<div class="content-wrapper p-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Task Allocation</h3>
        </div>
        <div>
             <button class="btn btn-success" id="exportBtn">
                <i class="bi bi-file-earmark-excel me-1"></i>
                Export
            </button>
            <button
                class="btn btn-primary"
                id="addTaskBtn">

                <i class="bi bi-plus-lg me-1"></i>
                 Add New Task
            </button>
        </div>

    </div>

    <!-- Filters -->
    <div class="pb-3 mb-3 border-bottom">
        <div class="row mb-4">

            <div class="col-md-2">
                <label>Project</label>

                <select
                    class="form-select"
                    id="project_filter">

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
            <div class="col-md-2">
                <label>Module</label>

                <select
                    class="form-select"
                    id="module_filter">

                    <option value="">
                        Select Module
                    </option>

                </select>
            </div>

            <div class="col-md-2">
                <label>Priority</label>

                <select
                    class="form-select"
                    id="priority">

                    <option value="">
                        Select Priority
                    </option>

                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                    <option value="Critical">Critical</option>

                </select>
            </div>

            <div class="col-md-2">
                <label>Status</label>

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

                    <option value="On Hold">
                        On Hold
                    </option>

                    <option value="Completed">
                        Completed
                    </option>

                </select>
            </div>

            <div class="col-md-2 d-flex align-items-end">

                <button
                    class="btn btn-primary w-100"
                    id="searchBtn">

                    Search

                </button>

            </div>

        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive">

        <table class="table table-striped table-hover align-middle w-100 data-table"
               id="taskTable">

            <thead>

                <tr>

                    <th>No</th>
                    <th>Task ID</th>
                    <th>Task Name</th>
                    <th>Project</th>
                    <th>Module</th>
                    <th>Assigned To</th>
                    <th>Assigned By</th>
                    <th>Priority</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Progress</th>
                    <th>Actions</th>

                </tr>

            </thead>

        </table>

    </div>

</div>
<div class="modal fade"
     id="viewTaskModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-scrollable">

        <div class="modal-content border-0">

            <div class="modal-header">

                <div>

                    <h5 class="fw-bold mb-1" id="v_task_name">
                        Sample Task Name
                    </h5>

                    <small class="text-muted">
                        View and manage task
                    </small>

                </div>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <div class="row">

                    <!-- LEFT -->
                    <div class="col-lg-8">

                        <h6 class="fw-bold mb-3">
                            Task Information
                        </h6>
                        <input type="hidden" id="task_id">
                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <small class="text-muted">Project</small>

                                <div id="v_project"></div>

                            </div>

                            <div class="col-md-6 mb-3">

                                <small class="text-muted">Module</small>

                                <div id="v_module"></div>

                            </div>

                            <div class="col-md-6 mb-3">

                                <small class="text-muted">Assigned To</small>

                                <div id="v_assigned_to"></div>

                            </div>

                            <div class="col-md-6 mb-3">

                                <small class="text-muted">Assigned By</small>

                                <div id="v_assigned_by"></div>

                            </div>

                            <div class="col-md-6 mb-3">

                                <small class="text-muted">Start Date</small>

                                <div id="v_start_date"></div>

                            </div>

                            <div class="col-md-6 mb-3">

                                <small class="text-muted">End Date</small>

                                <div id="v_end_date"></div>

                            </div>
                            <div class="col-md-6 mb-3">

                                <small class="text-muted">Estimated Hours</small>

                                <div id="v_estimated_hours"></div>

                            </div>
                            <div class="col-md-6 mb-3">

                                <small class="text-muted">Remaining Hours</small>

                                <div id="v_remaining_hours"></div>

                            </div>
                            <div class="col-md-6 mb-3">

                                <small class="text-muted">Priority</small>

                                <div id="v_priority"></div>

                            </div>

                            

                            <div class="col-md-6 mb-3">

                                <small class="text-muted">
                                    Dependencies
                                </small>

                                <div id="v_dependencies"></div>

                            </div>

                            <div class="col-md-12 mb-3">

                                <small class="text-muted">
                                    Attachment
                                </small>

                                <div id="v_attachment"></div>

                            </div>

                        </div>

                        <hr>

                        <h6 class="fw-bold mb-3">
                            Task Progress Update
                        </h6>

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label>Status</label>

                                <select class="form-select"
                                        id="update_status">

                                    <option value="Not Started">
                                        Not Started
                                    </option>

                                    <option value="In Progress">
                                        In Progress
                                    </option>

                                    <option value="On Hold">
                                        On Hold
                                    </option>

                                    <option value="Completed">
                                        Completed
                                    </option>

                                </select>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label>Progress</label>

                                <input type="range"
                                       class="form-range"
                                       min="0"
                                       max="100"
                                       value="0"
                                       id="update_progress">

                                <div class="text-end">
                                    <span id="progressText">
                                        0%
                                    </span>
                                </div>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label>Hours Worked Today</label>

                                <input type="number"
                                       class="form-control"
                                       id="hours_worked">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label>Total Hours Left</label>
  
                                <input type="number"
                                       class="form-control"
                                       id="remaining_hours">

                            </div>
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Challenges / Blockers
                                </label>

                                <select class="form-select"
                                        id="challenge"
                                        name="challenge">

                                    <option value="No Issues">
                                        No Issues
                                    </option>

                                    <option value="Waiting for Client">
                                        Waiting for Client
                                    </option>

                                    <option value="Waiting for Approval">
                                        Waiting for Approval
                                    </option>

                                    <option value="Waiting for Dependency">
                                        Waiting for Dependency
                                    </option>

                                    <option value="Technical Issue">
                                        Technical Issue
                                    </option>

                                    <option value="Requirement Clarification">
                                        Requirement Clarification
                                    </option>

                                    <option value="Other">
                                        Other
                                    </option>

                                </select>

                            </div>

                            <div class="col-md-12">

                                <label>Work Summary</label>

                                <textarea class="form-control"
                                          rows="3"
                                          id="work_summary"></textarea>

                            </div>

                        </div>

                    </div>

                    <!-- RIGHT -->
                    <div class="col-lg-4 border-start">

                        <h6 class="fw-bold mb-3">
                            History
                        </h6>

                        <div id="historyContainer">

                            <!-- Dynamic Timeline -->

                        </div>

                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button class="btn btn-light"
                        data-bs-dismiss="modal">

                    Cancel

                </button>

                <button class="btn btn-primary"
                        id="updateTaskBtn">

                    Submit

                </button>

            </div>

        </div>

    </div>

</div>
<div class="modal fade" id="editTaskModal" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form id="editTaskForm" enctype="multipart/form-data">

                @csrf

                <div class="modal-header">

                    <h5 class="modal-title">
                        Edit Task
                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <input type="hidden"
                           id="editTaskId"
                           name="task_id">
                    <div class="row">
                        <!-- Assigned To -->
                        <div class="col-lg-6 mb-3">
                            <label>Assigned To</label>

                            <select class="form-select"
                                    name="assigned_to"
                                    id="editAssignedTo">

                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">
                                        {{ $employee->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <!-- Start Date -->
                        <div class="col-lg-6 mb-3">
                            <label>Start Date</label>

                            <input type="date"
                                class="form-control"
                                name="start_date"
                                id="editStartDate">
                        </div>

                        <!-- End Date -->
                        <div class="col-lg-6 mb-3">
                            <label>End Date</label>

                            <input type="date"
                                class="form-control"
                                name="end_date"
                                id="editEndDate">
                        </div>

                        <!-- Estimated Hour -->
                        <div class="col-lg-6 mb-3">
                            <label>Estimated Hour</label>

                            <input type="number"
                                step="0.5"
                                class="form-control"
                                name="estimated_hour"
                                id="editEstimatedHour">
                        </div>

                        <!-- Remaining Hour -->
                        <div class="col-lg-6 mb-3">
                            <label>Remaining Hour</label>

                            <input type="number"
                                    step="0.5"
                                class="form-control"
                                name="remaining_hour"
                                id="editRemainingHour" readonly>
                        </div>

                        <!-- Dependencies -->
                        <div class="col-lg-6 mb-3">
                            <label>Dependencies</label>

                            <textarea class="form-control"
                                    name="dependencies"
                                    id="editDependencies"></textarea>
                        </div>

                        <!-- Attachment -->
                        <div class="col-lg-6 mb-3">

                            <label>Attachment</label>

                            <input type="file"
                                class="form-control"
                                name="attachment">

                        </div>
                        <div class="col-lg-6 mb-3 d-flex flex-column">

                            <div id="attachmentPreview" class="mt-auto"></div>

                        </div>

                    </div>
                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Close
                    </button>

                    <button type="submit"
                            class="btn btn-primary">
                        Update Task
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
<div class="modal fade"
     id="taskModal"
     tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content border-0">

            <div class="modal-header border-0">

                <div>
                    <h4 class="fw-bold mb-1">
                        Create New Task
                    </h4>

                    <small class="text-muted">
                        Enter task details to create a new task and track its progress.
                    </small>
                </div>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <form id="taskForm" enctype="multipart/form-data">

                    @csrf

                    <input type="hidden"
                           name="id"
                           id="task_id">

                    <hr>

                    <h6 class="mb-3">
                        General Information
                    </h6>

                    <div class="row g-3">

                        <div class="col-md-6">

                            <label class="form-label">
                                Project
                            </label>

                            <select class="form-select"
                                    name="project_id"
                                    id="project_id">

                                <option value="">
                                    Select project
                                </option>

                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}">
                                        {{ $project->project_name }}
                                    </option>
                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">
                                Modules
                            </label>

                            <select class="form-select"
                                    name="module_id"
                                    id="module_id">

                                <option value="">
                                    Select modules
                                </option>

                            </select>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">
                                Task Name
                            </label>

                            <input type="text"
                                   name="task_name"
                                   class="form-control"
                                   placeholder="Enter task name">

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">
                                Assigned To
                            </label>

                            <select class="form-select"
                                    name="assigned_to"
                                    id="assigned_to">

                                <option value="">
                                    Select Employee
                                </option>

                            </select>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">
                                Start Date
                            </label>

                            <input type="date"
                                   class="form-control"
                                   name="start_date">

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">
                                End Date
                            </label>

                            <input type="date"
                                   class="form-control"
                                   name="end_date">

                        </div>

                    </div>

                    {{-- <div class="alert alert-success mt-3 mb-3">

                        Available capacity for the selected period is
                        <strong>25 hours</strong>.
                        You are allocating
                        <strong>20 hours</strong>
                        to this task, leaving
                        <strong>5 hours</strong>
                        available.

                    </div> --}}

                    <div class="row g-3">

                        <div class="col-md-6">

                            <label class="form-label">
                                Priority
                            </label>

                            <select class="form-select"
                                    name="priority">

                                <option value="">
                                    Select priority
                                </option>

                                <option value="Low">
                                    Low
                                </option>

                                <option value="Medium">
                                    Medium
                                </option>

                                <option value="High">
                                    High
                                </option>

                                <option value="Critical">
                                    Critical
                                </option>

                            </select>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">
                                Estimated Hours
                            </label>

                            <input type="number"
                                   step="0.5"
                                   min="0"
                                   class="form-control"
                                   name="estimated_hours"
                                   placeholder="00:00">

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">
                                Dependencies
                            </label>

                            <input type="text"
                                   class="form-control"
                                   name="dependencies"
                                   placeholder="Enter dependencies here">

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">
                                Attachment
                            </label>

                            <input type="file"
                                   class="form-control"
                                   name="attachment">

                            <small class="text-muted">
                                PDF (Max 5MB)
                            </small>

                        </div>

                    </div>

                </form>

            </div>

            <div class="modal-footer border-0">

                <button type="button"
                        class="btn btn-light px-4"
                        data-bs-dismiss="modal">

                    Cancel

                </button>

                <button type="button"
                        class="btn btn-primary px-5"
                        id="saveTaskBtn">

                    Submit

                </button>

            </div>

        </div>

    </div>

</div>
<div class="modal fade" id="attachmentModal">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header">

                <h5>Attachment</h5>

                <button class="btn-close"
                        data-bs-dismiss="modal"></button>

            </div>

            <div class="modal-body p-0">

                <iframe
                    id="attachmentFrame"
                    width="100%"
                    height="600"
                    frameborder="0">
                </iframe>

            </div>

        </div>

    </div>

</div>



<script>
    
$('#saveTaskBtn').click(function () {

    let formData = new FormData(
        document.getElementById('taskForm')
    );

    $.ajax({

        url: "{{ route('tasks.store') }}",

        type: "POST",

        data: formData,

        processData: false,

        contentType: false,

        success: function(res){

            if(res.status){

                $('#taskModal').modal('hide');

                $('#taskForm')[0].reset();

                $('#module_id').html(
                    '<option value="">Select modules</option>'
                );

                table.ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: res.message
                });

            }

        },

        error: function(xhr){

            let errors = '';

            if(xhr.responseJSON?.errors){

                $.each(
                    xhr.responseJSON.errors,
                    function(key,value){

                        errors += value[0] + '<br>';

                    }
                );

            }

            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: errors || 'Something went wrong'
            });

        }

    });

});
$(document).on('click', '#exportBtn', function () {

    let project_id = $('#project_id').val() || '';
    let module_id  = $('#module_id').val() || '';
    let priority   = $('#priority').val() || '';
    let status     = $('#status').val() || '';

    let url = "{{ route('tasks.export') }}?" + $.param({
        project_id: project_id,
        module_id: module_id,
        priority: priority,
        status: status
    });

    window.location.href = url;

});
$('#addTaskBtn').click(function(){

    $('#taskForm')[0].reset();

    $('#task_id').val('');

    $('#taskModalTitle').text('Add Task');

    $('#taskModal').modal('show');

});

$('#project_id').change(function(){

    let projectId = $(this).val();

    $('#module_id').html(
        '<option value="">Select Module</option>'
    );

    $('#assigned_to').html(
        '<option value="">Select Employee</option>'
    );

    if(projectId == ''){
        return;
    }

    // Load Modules
    $.get(
        "{{ url('tasks/project-modules') }}/" + projectId,
        function(res){

            let html =
                '<option value="">Select Module</option>';

            $.each(res,function(index,module){

                html += `
                    <option value="${module.id}">
                        ${module.name}
                    </option>
                `;
            });

            $('#module_id').html(html);

        }
    );

    // Load Team Members
    $.get(
        "{{ url('tasks/project-team-members') }}/" + projectId,
        function(res){

            let html =
                '<option value="">Select Employee</option>';

            $.each(res,function(index,member){

                html += `
                    <option value="${member.id}">
                        ${member.name}
                    </option>
                `;
            });

            $('#assigned_to').html(html);

        }
    );

});

$('#project_filter').change(function(){
    let projectId = $(this).val();
    $('#module_filter').html(
        '<option value="">Select Module</option>'
    );
    if(projectId == ''){
        return;
    }
    $.get(
        "{{ url('tasks/project-modules') }}/" + projectId,
        function(res){
            let html =
                '<option value="">Select Module</option>';
            $.each(res,function(index,module){
                html += `
                    <option value="${module.id}">
                        ${module.name}
                    </option>
                `;
            });
            $('#module_filter').html(html);
        }
    );
});
var table = $('#taskTable').DataTable({

    processing: true,

    serverSide: true,

    ajax: {

        url: "{{ route('tasks.list') }}",

        data: function(d){

            d.project_id = $('#project_filter').val();

            d.module_id = $('#module_filter').val();

            d.priority = $('#priority').val();

            d.status = $('#status').val();

        }
    },

    columns: [

        {
            data:'DT_RowIndex',
            orderable:false,
            searchable:false
        },

        {
            data:'task_code'
        },

        {
            data:'task_name'
        },
        {
            data: 'project_name'
        },
        {
            data:'module_name'
        },

        {
            data:'assigned_to_name'
        },

        {
            data:'assigned_by_name'
        },

        {
            data:'priority'
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
            data:'progress_bar',
            orderable:false,
            searchable:false
        },

        {
            data:'action',
            orderable:false,
            searchable:false
        }

    ]

});

$('#searchBtn').click(function(){

    table.ajax.reload();

});
$(document).on('click', '.deleteBtn', function () {

    let id = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to recover this task!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, Delete'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: "/tasks/delete/" + id,
                type: "DELETE",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {

                    if (response.status) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });

                        $('#taskTable').DataTable().ajax.reload(null, false);

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Cannot Delete',
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
$(document).on('click', '.viewBtn', function () {

    let id = $(this).data('id');

    $.ajax({

        url: '/tasks/view-my-task/' + id,
        type: 'GET',

        success: function (res) {

            if (!res.status) {
                return;
            }

            let task = res.task;
            $('#task_id').val(task.id);
            // Task Information
            $('#v_project').text(task.project_name);
            $('#v_module').text(task.module_name);
            $('#v_task_name').text(task.task_name);
            $('#v_assigned_to').text(task.assigned_to);
            $('#v_assigned_by').text(task.assigned_by);
            $('#v_start_date').text(task.start_date);
            $('#v_end_date').text(task.end_date);
            $('#v_priority').text(task.priority);

            $('#v_estimated_hours').text(task.estimated_hours);
            $('#remaining_hours').val(task.remaining_hours);
            $('#v_remaining_hours').text(task.remaining_hours);
            $('#hours_worked').val('').attr('max', task.remaining_hours);

            $('#v_dependencies').text(task.dependencies);
            $('#update_progress').val(res.task.progress);
            $('#update_status').val(res.task.status);
            $('#progressText').text(
                res.task.progress + '%'
            );
            $('#challenge').val(res.task.challenge ?? 'No Issues');
            if(task.attachment){

                $('#v_attachment').html(
                    '<a href="#" class="viewAttachment" data-url="'+task.attachment+'">View Attachment</a>'
                );

            }else{

                $('#v_attachment').html('-');

            }

            
            // History
            let history = '';

            $.each(res.history,function(index,item){

                history += `
                    <div class="timeline-item">

                        <div class="timeline-date">
                            ${item.created_at}
                        </div>

                        <div class="fw-bold">
                            ${item.employee_name}
                        </div>

                        <div class="timeline-progress">
                            Progress : ${item.progress}%
                        </div>

                        <div>
                            Status : ${item.status}
                        </div>

                        <div>
                            Worked : ${item.hours_worked} Hours
                        </div>

                        <div>
                            Remaining : ${item.remaining_hours} Hours
                        </div>

                        <div>
                            Challenge : ${item.challenge ?? 'No Issues'}
                        </div>

                        <div class="timeline-summary">
                            Remarks : ${item.work_summary ?? '-'}
                        </div>

                    </div>
                    `;
            });

            $('#historyContainer').html(history);

            $('#viewTaskModal').modal('show');

        }

    });

});
$(document).on('click', '#updateTaskBtn', function () {

    $.ajax({

        url: "{{ route('tasks.update') }}",
        type: "POST",

        data: {

            _token: $('meta[name="csrf-token"]').attr('content'),

            task_id: $('#task_id').val(),
            status: $('#update_status').val(),
            progress: $('#update_progress').val(),
            hours_worked: $('#hours_worked').val(),
            remaining_hours: $('#remaining_hours').val(),
            challenge: $('#challenge').val(),
            work_summary: $('#work_summary').val()

        },

        beforeSend: function () {

            $('#updateTaskBtn')
                .prop('disabled', true)
                .text('Saving...');

        },

        success: function (res) {

            $('#updateTaskBtn')
                .prop('disabled', false)
                .text('Submit');

            if (res.status) {

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: res.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {

                    $('#viewTaskModal').modal('hide');

                    table.ajax.reload(null, false);

                });

            } else {

                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: res.message
                });

            }

        },

        error: function (xhr) {

            $('#updateTaskBtn')
                .prop('disabled', false)
                .text('Submit');

            let message = 'Something went wrong.';

            if (xhr.responseJSON) {

                if (xhr.responseJSON.errors) {

                    message = Object.values(xhr.responseJSON.errors)
                        .flat()
                        .join('<br>');

                } else if (xhr.responseJSON.message) {

                    message = xhr.responseJSON.message;

                }

            }

            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: message
            });

        }

    });

});
$(document).on('click','.viewAttachment',function(e){

    e.preventDefault();

    $('#attachmentFrame').attr('src',$(this).data('url'));

    $('#attachmentModal').modal('show');

});
$('#hours_worked').on('input', function () {
    let max = parseFloat($('#v_remaining_hours').text()) || 0;
    let worked = parseFloat($(this).val()) || 0;
    if (worked > max) {
        worked = max;
        $(this).val(max);
    }
    $('#remaining_hours').val((max - worked).toFixed(2));

});
$('#update_progress').on('input', function () {

    let value = $(this).val();

    $('#progressText').text(value + '%');

    $('#progress_bar').css('width', value + '%');
    $('#progress_bar').text(value + '%');

});
var originalEstimated = 0;
var originalRemaining = 0;
$(document).on('click', '.editBtn', function () {

    let id = $(this).data('id');

    $.ajax({

        url: '/tasks/edit/' + id ,

        type: 'GET',

        success: function (res) {
        // console.log(res);
            $('#editTaskId').val(res.task.id);

            $('#editAssignedTo').val(res.task_update.employee_id).trigger('change');

            $('#editStartDate').val(res.task_update.start_date);

            $('#editEndDate').val(res.task_update.end_date);

            originalEstimated = parseFloat(res.estimated_hour);
            originalRemaining = parseFloat(res.remaining_hour);

            $('#editEstimatedHour').val(originalEstimated);
            $('#editRemainingHour').val(originalRemaining).css({'background-color': '#f3e9e9'});

            $('#editDependencies').val(res.task_update.dependencies);

            if(res.task_update.attachment){

                $('#attachmentPreview').html(
                    '<button href="#" class="viewAttachment btn btn-success" data-url="'+res.task_update.attachment+'">View Attachment</button>'
                );

            }else{

                $('#attachmentPreview').html('-');

            }
           

            $('#editTaskModal').modal('show');

        }

    });

});
$('#editEstimatedHour').on('input', function () {

    let newEstimated = parseFloat($(this).val()) || 0;

    let difference = newEstimated - originalEstimated;

    let newRemaining = originalRemaining + difference;

    if (newRemaining < 0) {
        newRemaining = 0;
    }

    $('#editRemainingHour').val(newRemaining.toFixed(2));

});

$('#editTaskForm').submit(function(e){

    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({

        url:'/tasks/allocationupdate',

        type:'POST',

        data:formData,

        processData:false,

        contentType:false,

        success:function(res){

            Swal.fire(
                'Success',
                res.message,
                'success'
            );

            $('#editTaskModal').modal('hide');

            $('#taskTable').DataTable().ajax.reload(null,false);

        },

        error:function(xhr){

            Swal.fire(
                'Error',
                xhr.responseJSON.message,
                'error'
            );

        }

    });

});
</script>