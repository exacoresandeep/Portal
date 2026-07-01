
<div class="content-wrapper p-3 mytask">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">My Tasks</h3>
        </div>

    </div>
    {{-- Dashboard Cards --}}
    <div class="row g-3 mb-4">

        <!-- Total Tasks -->
        <div class="col-md">
            <div class="card task-card">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-circle total-bg me-3">
                        <i class="bi bi-clipboard-check"></i>
                    </div>

                    <div>
                        <div class="task-label">Total Tasks</div>
                        <p class="task-count text-primary" id="total_tasks">{{ $totalTasks }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- In Progress -->
        <div class="col-md">
            <div class="card task-card">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-circle progress-bg me-3">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>

                    <div>
                        <div class="task-label">In Progress</div>
                        <p class="task-count text-warning" id="inprogress_tasks">{{ $inProgressTasks }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="col-md">
            <div class="card task-card">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-circle pending-bg me-3">
                        <i class="bi bi-hourglass-split"></i>
                    </div>

                    <div>
                        <div class="task-label">Pending</div>
                        <p class="task-count" style="color:#d946ef" id="pending_tasks">{{ $pendingTasks }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Over Due -->
        <div class="col-md">
            <div class="card task-card">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-circle overdue-bg me-3">
                        <i class="bi bi-calendar-x"></i>
                    </div>

                    <div>
                        <div class="task-label">Over Due</div>
                        <p class="task-count text-danger" id="overdue_tasks">{{ $overdueTasks }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed -->
        <div class="col-md">
            <div class="card task-card">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-circle completed-bg me-3">
                        <i class="bi bi-check2-circle"></i>
                    </div>

                    <div>
                        <div class="task-label">Completed</div>
                        <p class="task-count text-success" id="completed_tasks">{{ $completedTasks }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

 
    <div class="mb-3 border-top align-items-end">
        
        <div class="pb-3 border-bottom align-items-end">
            <div class="row mb-2 mt-2">
                <div class="col-md-2">
    <label class="form-label">Project</label>

                    <select class="form-select" id="project_filter">

                        <option value="">All Projects</option>

                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">
                                {{ $project->project_name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Module</label>

                    <select class="form-select" id="module_filter">

                        <option value="">All Modules</option>

                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Priority</label>
                    <select class="form-select" id="priority_filter">
                        <option value="">All</option>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                        <option value="Critical">Critical</option>
                    </select>
                </div>

                {{-- <div class="col-md-2">
                    <label class="form-label">Due Date</label>
                    <input type="date"
                        class="form-control"
                        id="due_date_filter">
                </div> --}}

                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select class="form-select" id="status_filter">

                        <option value="">All</option>

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
                    <button class="btn btn-primary w-100"
                            id="searchTask">
                        Search
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <table id="taskTable"
       class="table table-striped table-hover align-middle w-100 data-table">

        <thead>
            <tr>
                <th>Sl No</th>
                <th>Task ID</th>
                <th>Task Name</th>
                <th>Project</th>
                <th>Module</th>
                <th>Priority</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Bal Hr</th>
                <th>Status</th>
                <th>Progress</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
   
</div>

{{-- VIEW TASK MODAL --}}

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
$('#project_filter').change(function () {

    let projectId = $(this).val();

    $('#module_filter').html(
        '<option value="">All Modules</option>'
    );

    if (projectId == '') {
        return;
    }

    $.get(
        "{{ route('tasks.project.modules', ':id') }}"
            .replace(':id', projectId),
        function (res) {

            let html = '<option value="">All Modules</option>';

            $.each(res, function (i, module) {

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

        url: "{{ route('tasks.mytask.list') }}",

        type: "GET",

        data: function (d) {

            d.project_id = $('#project_filter').val();

            d.module_id = $('#module_filter').val();

            d.priority = $('#priority_filter').val();

            d.status = $('#status_filter').val();
        }
    },

    columns: [

        {
            data: 'DT_RowIndex',
            orderable: false,
            searchable: false
        },

        {
            data: 'task_code'
        },

        {
            data: 'task_name'
        },

        {
            data: 'project_name'
        },

        {
            data: 'module_name'
        },

        {
            data: 'priority'
        },

        {
            data: 'start_date'
        },

        {
            data: 'end_date'
        },
        {
            data: 'remaining_hours'
        },

        {
            data: 'status'
        },

        {
            data: 'progress',
            orderable: false,
            searchable: false
        },

        {
            data: 'action',
            orderable: false,
            searchable: false
        }

    ]

});

$('#searchTask').click(function () {

    table.ajax.reload();

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
                            Remarks: ${item.work_summary ?? '-'}
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
</script>