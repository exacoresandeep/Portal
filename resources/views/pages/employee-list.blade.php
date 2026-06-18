<div class="content-wrapper p-3">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">Employee Directory</h3>
        </div>
       <div>
            <button class="btn btn-success" id="exportBtn">
                <i class="bi bi-file-earmark-excel me-1"></i>
                Export
            </button>
            {{-- <button class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>
                Add Employee
            </button>  --}}
        </div> 

    </div>
    <div class="pb-3 mb-3 border-bottom ">
        <div class="card-body">

            <div class="row g-3 align-items-end">

                <!-- Onboarding Status -->
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <label class="form-label">Status</label>
                    <select class="form-select" id="filter_status">
                        <option value="" selected>Select</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <!-- Type -->
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <label class="form-label">Type</label>

                    <select class="form-select" id="filter_job_type" >
                        <option selected  value="" >Select type</option>
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

                    <select id="filter_department"  class="form-select">
                        <option selected value="" >Select department</option>
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

                    <select class="form-select"  id="filter_designation">
                        <option  value=""  selected>Select designation</option>
                        @foreach($designations as $designation)

                            <option value="{{ $designation->id }}">

                                {{ $designation->name }}

                            </option>

                        @endforeach

                    </select>
                </div>

                <!-- Search Button -->
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <button type="button" class="btn btn-primary w-100" id="searchBtn">
                        Search
                    </button>
                </div>

            </div>

        </div>
    </div>

    

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

                    <th>Emergency Contact</th>

                    <th width="120">Action</th>

                </tr>

            </thead>

        </table>

    </div>

        

</div>

<!-- View Modal -->
<div class="modal fade"
     id="employeeProfileModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">

            <!-- Header -->
            <div class="modal-header border-0">

                <div class="d-flex align-items-center gap-3">

                    <img src="{{ asset('assets/img/user.png') }}"
                         id="employee_profile_image"
                         class="rounded-circle"
                         width="70"
                         height="70">

                    <div>
                        <h5 class="fw-bold mb-1" id="employee_name"></h5>

                        <div class="text-muted small" id="employee_designation"></div>

                        <div class="text-muted small" id="employee_code"></div>
                    </div>

                </div>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

            </div>

            <div class="modal-body">

                <hr>

                <ul class="nav nav-pills mb-4 gap-2"
                    id="employeeProfileTabs"
                    role="tablist">

                    <li class="nav-item">
                        <button class="nav-link active"
                                data-bs-toggle="pill"
                                data-bs-target="#employeeProfileInfo">
                            Profile Information
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link"
                                data-bs-toggle="pill"
                                data-bs-target="#employeeOfficialInfo">
                            Official Information
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link"
                                data-bs-toggle="pill"
                                data-bs-target="#employeeIdentityInfo">
                            Identity Information
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link"
                                data-bs-toggle="pill"
                                data-bs-target="#employeeEducationInfo">
                            Educational Information
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link"
                                data-bs-toggle="pill"
                                data-bs-target="#employeeBankInfo">
                            Banking Details
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link"
                                data-bs-toggle="pill"
                                data-bs-target="#employeeDocumentInfo">
                            Document Management
                        </button>
                    </li>

                </ul>

                <div class="tab-content">

                    <div class="tab-pane fade show active"
                         id="employeeProfileInfo">
                        Employee Profile Information
                    </div>

                    <div class="tab-pane fade"
                         id="employeeOfficialInfo">
                        Employee Official Information
                    </div>

                    <div class="tab-pane fade"
                         id="employeeIdentityInfo">
                        Employee Identity Information
                    </div>

                    <div class="tab-pane fade"
                         id="employeeEducationInfo">
                        Employee Educational Information
                    </div>

                    <div class="tab-pane fade"
                         id="employeeBankInfo">
                        Employee Banking Details
                    </div>

                    <div class="tab-pane fade"
                         id="employeeDocumentInfo">
                        Employee Documents
                    </div>

                </div>

            </div>

        </div>
    </div>

</div>

<!--edit Modal-->


<script>
function viewEmployee(id)
{
    $.ajax({
        url: '/employee/details/' + id,
        type: 'GET',

        success: function(response) {

            $('#employee_name').text(response.name);
            $('#employee_profile_image').attr('src', response.photo_url);
            $('#employee_email').text(response.email);
            $('#employee_department').text(response.department?.name ?? '-');
            $('#employee_job_type').text(response.job_type);
            $('#employee_emp_id').text(response.emp_id);
            $('#employee_designation').text(response.designation?.name ?? '-');
            $('#employee_reporting_manager').text(response.reporting_manager?.name ?? '-');
            $('#employee_joining_date').text(response.joining_date);
            $('#employee_confirm_date').text(response.confirm_date);

            $('#employee_status').text(
                response.status == 1 ? 'Active' : 'Inactive'
            );

            $('#employeeProfileModal').modal('show');
        },
            error: function(xhr, status, error) {

            console.error(error);

            alert('Unable to fetch employee details. Please try again.');

            // Optional: clear modal fields
            $('#employee_name').text('');
            $('#employee_email').text('');
        }
    });
}
$(document).ready(function () {

    
    $('#exportBtn').click(function () {

        let status = $('#filter_status').val();

        let job_type = $('#filter_job_type').val();

        let department_id = $('#filter_department').val();

        let designation_id = $('#filter_designation').val();

        let url =
            "{{ route('employees.export') }}" +

            '?status=' + status +

            '&job_type=' + job_type +

            '&department_id=' + department_id +

            '&designation_id=' + designation_id;

        window.location.href = url;

    });
    let table = $('#employeeTable').DataTable({

        processing: true,

        serverSide: true,

        ajax: {
            url: "{{ route('employees.list') }}",
            data: function (d) {

                    d.status = $('#filter_status').val() || '';

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
                data: 'alt_contact_no',
                name: 'alt_contact_no',
            },

            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }

        ]

    });

    $('#searchBtn').click(function () {

        table.ajax.reload();

    });

});

</script>