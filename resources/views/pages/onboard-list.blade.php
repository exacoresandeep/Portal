<div class="content-wrapper p-3">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">Onboard Employee</h3>
        </div>

        <div>
            <button class="btn btn-success" id="exportBtn">
                <i class="bi bi-file-earmark-excel me-1"></i>
                Export
            </button>

            <button class="btn btn-primary"  data-bs-toggle="modal"
        data-bs-target="#addEmployeeModal">
                <i class="bi bi-plus-lg me-1"></i>
                Add Employee
            </button> 
        </div>

    </div>

    <!-- Filters -->
    <div class="pb-3 mb-3 border-bottom">
        <div class="card-body">

            <div class="row g-3 align-items-end">

                <!-- Onboarding Status -->
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <label class="form-label">Onboarding Status</label>

                    <select class="form-select" id="filter_onboard_status">
                        <option value="">Select status</option>
                        <option value="Pending">Pending</option>
                        <option value="Profile Created">Profile Created</option>
                        {{-- <option value="Completed">Completed</option> --}}
                    </select>
                </div>

                <!-- Status -->
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <label class="form-label">Status</label>

                    <select class="form-select" id="filter_status">
                        <option value="">Select status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <!-- Type -->
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <label class="form-label">Type</label>

                    <select class="form-select" id="filter_job_type">

                        <option value="">Select type</option>

                        @foreach($jobTypes as $jobType)

                            <option value="{{ $jobType->type }}">
                                {{ $jobType->type }}
                            </option>

                        @endforeach

                    </select>
                </div>

                <!-- Department -->
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <label class="form-label">Department</label>

                    <select class="form-select" id="filter_department">

                        <option value="">Select department</option>

                        @foreach($departments as $department)

                            <option value="{{ $department->id }}">
                                {{ $department->name }}
                            </option>

                        @endforeach

                    </select>
                </div>

                <!-- Designation -->
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <label class="form-label">Designation</label>

                    <select class="form-select" id="filter_designation">

                        <option value="">Select designation</option>

                        @foreach($designations as $designation)

                            <option value="{{ $designation->id }}">
                                {{ $designation->name }}
                            </option>

                        @endforeach

                    </select>
                </div>

                <!-- Search -->
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <button type="button"
                            class="btn btn-primary w-100"
                            id="searchBtn">

                        Search

                    </button>
                </div>

            </div>

        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive">

        <table class="table table-striped table-hover align-middle w-100 data-table"
               id="employeeTable">

            <thead class="table-light">

                <tr>

                    <th>Sl No.</th>

                    <th>Employee Name</th>

                    <th>Employee ID</th>

                    <th>Status</th>

                    <th>Job Type</th>

                    <th>Designation</th>

                    <th>Reporting Manager</th>

                    <th>Contact</th>

                    <th>Onboard Status</th>

                    <th width="120">Action</th>

                </tr>

            </thead>

        </table>

    </div>

</div>


<!--  add Modal-->
<!-- Add Employee Modal -->
<div class="modal fade"
     id="addEmployeeModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content border-0 rounded-4">

            <!-- Header -->
            <div class="modal-header border-0 pb-0">

                <div>
                    <h4 class="fw-bold mb-1" id="employeeModalTitle">
                        Add New Employee
                    </h4>

                    <p class="text-muted small mb-0">
                        Enter employee details to set up their profile and enable secure portal access.
                    </p>
                </div>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

            </div>

            <div class="modal-body pt-4">

                <hr>

                <h6 class="fw-semibold mb-4">
                    General Information
                </h6>

                <form>

                    <div class="row g-4">

                        <!-- Left Side -->
                        <div class="col-md-6">

                            <!-- Employee Name -->
                            <div class="mb-3">
                                <label class="form-label">
                                    Employee Name
                                </label>

                                <input type="text" class="form-control" id="employee_name" placeholder="Enter employee name">
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label">
                                    Email ID
                                </label>

                                <input type="email"
                                    class="form-control"
                                    id="employee_email"
                                    placeholder="Enter email address">
                            </div>

                            <!-- Department -->
                            <div class="mb-3">
                                <label class="form-label">
                                    Department
                                </label>

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

                            <!-- Type -->
                            <div class="mb-3">
                                <label class="form-label">
                                    Type
                                </label>

                                <select class="form-select" id="job_type">

                                    <option selected>
                                        Select Type
                                    </option>

                                    @foreach($jobTypes as $jobType)

                                        <option value="{{ $jobType->type }}">
                                            {{ $jobType->type }}
                                        </option>

                                    @endforeach

                                </select>
                            </div>
                             <div class="mb-3">
                                <label class="form-label">
                                    Confirm Date
                                </label>

                                <input type="date"
                                    class="form-control"
                                    id="confirm_date">
                            </div>

                        </div>

                        <!-- Right Side -->
                        <div class="col-md-6">

                            <!-- Employee ID -->
                            <div class="mb-3">
                                <label class="form-label">
                                    Employee ID
                                </label>

                                <input type="text"
                                    class="form-control"
                                    id="emp_id"
                                    placeholder="Enter employee ID">
                            </div>

                            <!-- Position -->
                            <div class="mb-3">
                                <label class="form-label">
                                    Position
                                </label>

                                <select class="form-select" id="designation_id">

                                    <option selected>
                                        Select Position
                                    </option>

                                    @foreach($designations as $designation)

                                        <option value="{{ $designation->id }}">
                                            {{ $designation->name }}
                                        </option>

                                    @endforeach

                                </select>
                            </div>

                            <!-- Reporting Manager -->
                            <div class="mb-3">
                                <label class="form-label">
                                    Reporting Manager
                                </label>

                                <select class="form-select" id="reporting_manager_id">

                                    <option selected>
                                        Select Reporting Manager
                                    </option>

                                    @foreach($managers as $manager)

                                        <option value="{{ $manager->id }}">
                                            {{ $manager->name }}
                                        </option>

                                    @endforeach

                                </select>
                            </div>

                            <!-- Joining Date -->
                            <div class="mb-3">
                                <label class="form-label">
                                    Joining Date
                                </label>

                                <input type="date"
                                    class="form-control"
                                    id="joining_date">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Status
                                </label>

                                <select class="form-select" id="status">
                                    <option value="1">Active</option>
                                    <option value="0">InActive</option>
                                </select>
                            </div>

                        </div>

                    </div>
                    <input type="hidden" id="employee_id">    
                    <!-- Footer Buttons -->
                    <div class="d-flex gap-3 mt-4">

                        <button type="button"
                                class="btn btn-light px-4"
                                data-bs-dismiss="modal">

                            Cancel

                        </button>

                        <button type="submit"
                                class="btn btn-primary px-4"
                                id="employeeSubmitBtn">

                            Add Employee

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<!-- view Modal-->
<!-- View Employee Modal -->
<div class="modal fade"
     id="viewEmployeeModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content border-0 rounded-4">

            <!-- Header -->
            <!-- Header -->
<div class="modal-header border-0 d-flex justify-content-between align-items-start">

    <!-- Left Side -->
    <div class="d-flex align-items-center gap-3">

        <!-- Profile -->
        <img src="https://i.pravatar.cc/100"
             class="rounded-circle"
             width="60"
             height="60">

        <div>

            <h5 class="fw-bold mb-1" id="view_name"></h5>

            <div class="text-muted small" id="view_designation"></div>

            <div class="text-muted small" id="view_empid"></div>

        </div>

    </div>

    <!-- Right Side -->
    <div class="d-flex align-items-center gap-2">

        <button class="btn btn-sm btn-light">
            <i class="bi bi-link-45deg"></i>
            Share Link
        </button>

        <button type="button"
                class="btn-close"
                data-bs-dismiss="modal">
        </button>

    </div>

</div>

            <div class="modal-body">

                <hr>

                <h6 class="fw-semibold mb-4">
                    General Information
                </h6>

                <div class="row gy-4">

                    <!-- Left -->
                    <div class="col-md-6">

                        <div class="mb-3">
                            <small class="text-muted d-block">
                                Email ID
                            </small>

                            <div class="fw-medium" id="view_email"></div>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">
                                Department
                            </small>

                            <div class="fw-medium" id="view_department"></div>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">
                                Type
                            </small>

                            <div class="fw-medium" id="view_type"></div>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">
                                Confirm Date
                            </small>

                            <div class="fw-medium" id="view_confirm"></div>
                        </div>

                    </div>

                    <!-- Right -->
                    <div class="col-md-6">

                        <div class="mb-3">
                            <small class="text-muted d-block">
                                Phone
                            </small>

                            <div class="fw-medium" id="view_phone"></div>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">
                                Reporting Manager
                            </small>

                            <div class="fw-medium" id="view_manager"></div>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">
                                Joining Date
                            </small>

                            <div class="fw-medium" id="view_joining"></div>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">
                                Status
                            </small>

                            <div class="fw-medium" id="view_status"></div>
                        </div>
                        

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

$(document).ready(function () {

    // Export
    $('#exportBtn').click(function () {

        let status = $('#filter_status').val();

        let onboard_status = $('#filter_onboard_status').val();

        let job_type = $('#filter_job_type').val();

        let department_id = $('#filter_department').val();

        let designation_id = $('#filter_designation').val();

        let url =
            "{{ route('onboard.export') }}" +

            '?status=' + status +

            '&onboard_status=' + onboard_status +

            '&job_type=' + job_type +

            '&department_id=' + department_id +

            '&designation_id=' + designation_id;

        window.location.href = url;

    });

    // DataTable
    let table = $('#employeeTable').DataTable({

        processing: true,

        serverSide: true,

        ajax: {

            url: "{{ route('onboard.list') }}",

            data: function (d) {

                d.status = $('#filter_status').val() || '';

                d.onboard_status = $('#filter_onboard_status').val() || '';

                d.job_type = $('#filter_job_type').val() || '';

                d.department_id = $('#filter_department').val() || '';

                d.designation_id = $('#filter_designation').val() || '';

            }

        },

        columns: [

            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },

            {
                data: 'employee_name',
                name: 'name'
            },

            {
                data: 'emp_id',
                name: 'emp_id'
            },

            {
                data: 'status_badge',
                name: 'status',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },

            {
                data: 'job_type',
                name: 'job_type'
            },

            {
                data: 'designation_name',
                name: 'designation.name'
            },

            {
                data: 'reporting_manager',
                name: 'reportingManager.name'
            },

            {
                data: 'contact_no',
                name: 'contact_no'
            },

            {
                data: 'onboard_badge',
                name: 'onboard_status',
                orderable: false,
                searchable: false
            },

            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }

        ]

    });

    // Search
    $('#searchBtn').click(function () {
        table.ajax.reload();
    });

    // VIEW EMPLOYEE
    $(document).on('click', '.viewEmployee', function () {

        let id = $(this).data('id');

        $.ajax({

            url: '/employee/details/' + id,
            type: 'GET',

            success: function (response) {

                $('#view_name').text(response.name);

                $('#view_designation').text(
                    response.designation?.name ?? '-'
                );

                $('#view_empid').text(response.emp_id);

                $('#view_email').text(response.email);

                $('#view_department').text(
                    response.department?.name ?? '-'
                );

                $('#view_type').text(response.job_type);

                $('#view_phone').text(response.contact_no);

                $('#view_manager').text(
                    response.reporting_manager?.name ?? '-'
                );

                $('#view_joining').text(response.joining_date);
                $('#view_confirm').text(response.confirm_date);
                $('#view_status').text(response.status == 1 ? 'Active' : 'Inactive');
            }

        });

    });

    // EDIT EMPLOYEE
    $(document).on('click', '.editEmployee', function () {

        let id = $(this).data('id');

        $.ajax({

            url: '/employee/details/' + id,
            type: 'GET',

            success: function (response) {

                // Modal Title
                $('#employeeModalTitle').text('Update Employee');

                // Button Text
                $('#employeeSubmitBtn').text('Update Employee');

                // Hidden ID
                $('#employee_id').val(response.id);

                // Form Values
                $('#employee_name').val(response.name);

                $('#employee_email').val(response.email);

                $('#department_id').val(response.department_id);

                $('#job_type').val(response.job_type);

                $('#emp_id').val(response.emp_id);

                $('#designation_id').val(response.designation_id);

                $('#reporting_manager_id').val(response.reporting_manager_id);

                $('#joining_date').val(response.joining_date);
                $('#confirm_date').val(response.confirm_date);
                $('#status').val(response.status);

            }

        });

    });

    // RESET MODAL FOR ADD
    $('#addEmployeeModal').on('hidden.bs.modal', function () {

        $('#employeeModalTitle').text('Add New Employee');

        $('#employeeSubmitBtn').text('Add Employee');

        $('#employee_id').val('');

        $(this).find('form')[0].reset();

    });

    // ADD / UPDATE EMPLOYEE
    $('#employeeSubmitBtn').click(function (e) {

        e.preventDefault();

        let employee_id = $('#employee_id').val();

        let formData = {

            name: $('#employee_name').val(),

            email: $('#employee_email').val(),

            department_id: $('#department_id').val(),

            job_type: $('#job_type').val(),

            emp_id: $('#emp_id').val(),

            designation_id: $('#designation_id').val(),

            reporting_manager_id: $('#reporting_manager_id').val(),

            joining_date: $('#joining_date').val(),
            confirm_date: $('#confirm_date').val(),
            status: $('#status').val(),

            _token: '{{ csrf_token() }}'

        };

        let url = '';

        if (employee_id == '') {

            url = "{{ route('employee.store') }}";

        } else {

            url = '/employee/update/' + employee_id;

        }

        $.ajax({

            url: url,

            type: 'POST',

            data: formData,

            success: function (response) {

                Swal.fire({

                    icon: 'success',

                    title: 'Success',

                    text: response.message,

                    timer: 2000,

                    showConfirmButton: false

                });

                $('#addEmployeeModal').modal('hide');

                $('#employeeTable').DataTable().ajax.reload();

            },

            error: function (xhr) {

                let errors = xhr.responseJSON.errors;

                let errorMsg = '';

                $.each(errors, function (key, value) {

                    errorMsg += value[0] + '\n';

                });

                Swal.fire({

                    icon: 'error',

                    title: 'Validation Error',

                    text: errorMsg

                });

            }

        });

    });

});

</script>