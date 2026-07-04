<div class="content-wrapper p-3">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">Offboarding Management</h3>
        </div>

        <div>
            <button class="btn btn-success" id="exportBtn">
                <i class="bi bi-file-earmark-excel me-1"></i>
                Export
            </button>

            <button class="btn btn-primary" id="addexitFormBtn">
                <i class="bi bi-plus-lg me-1"></i>
                 Create Exit Form
            </button> 
        </div>

    </div>

    <!-- Filters -->
    <div class="pb-3 mb-3 border-bottom">
        <div class="card-body">

            <div class="row g-3 align-items-end">

                <!-- Onboarding Status -->
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <label class="form-label">Submission Status</label>

                    <select class="form-select" id="filter_emp_process">
                        <option value="">Select status</option>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <!-- Status -->
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <label class="form-label">HR Process Status</label>

                    <select class="form-select" id="filter_hr_process">
                        <option value="">Select status</option>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
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

                    
                    <th>Job Type</th>
                    
                    <th>Designation</th>
                    
                    <th>Reporting Manager</th>
                    
                    <th>Joining Date</th>
                    
                    <th>Leaving Date</th>

                    <th>Submission Status</th>
                    
                    <th>HR Process Status</th>

                    <th width="120">Action</th>

                </tr>

            </thead>

        </table>

    </div>

</div>


<!--  add Modal-->
<!-- Add Employee Modal -->
<div class="modal"
     id="addExitFormModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content border-0 rounded-4">

            <!-- Header -->
            <div class="modal-header border-0 pb-0">

                <div>
                    <h4 class="fw-bold mb-1" id="employeeModalTitle">
                        Create Exit Form
                    </h4>

                    <p class="text-muted small mb-0">
                        Enter employee details and create an exit form to manage the offboarding process.
                    </p>
                </div>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

            </div>

            <div class="modal-body pt-4">

                <hr>                
                    <div class="section-title mb-3"><strong>General Information</strong></div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Employee Name</label>
                             <select class="form-select" id="employee_select">
                                <option value="">Select Employee</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Employee ID</label>
                            <input type="text" id="employee_id" class="form-control" placeholder="Auto-fill employee ID" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Department</label>
                            <input type="text" id="department_id" class="form-control" placeholder="Auto-fill department" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Designation</label>
                            <input type="text" id="designation_id" class="form-control" placeholder="Auto-fill designation" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Reporting Manager</label>
                            <input type="text" id="reporting_manager" class="form-control" placeholder="Auto-fill reporting manager" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Joining Date</label>
                            <input type="text" id="joining_date" class="form-control" placeholder="Auto-fill joining date" readonly>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">Last Working Day</label>
                            <input type="date" class="form-control" id="leaving_date">
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <button class="btn btn-light btn-cancel">Cancel</button>
                        <button class="btn btn-primary btn-submit" id="createExitFormSubmit">Submit</button>
                    </div>

                

            </div>

        </div>

    </div>

</div>

<!-- view Modal-->
<div class="modal fade"
     id="viewOffboardModal">

    <div class="modal-dialog modal-xl">

        <div class="modal-content border-0 shadow-none rounded-0">
            <div class="modal-header">
                <h5 class="modal-title">View Details</h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                </button>
            </div>
            <div class="modal-body" id="viewModalContent"></div>

        </div>

    </div>

</div>

<div class="modal fade" id="pdfModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
             <div class="modal-header">
                <h5 class="modal-title">Document Preview</h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <iframe id="pdfFrame"
                        width="100%"
                        height="700">
                </iframe>
            </div>
        </div>
    </div>
</div>
<script>
function viewSignature(url)
{
    $('#pdfFrame').attr('src', url);
    $('#pdfModal').modal('show');
}
function loadEmployees()
{
    $.get(
        "{{ route('active.employees') }}",
        function(response){

            $('#employee_select').empty();

            $('#employee_select').append(
                '<option value="">Select Employee</option>'
            );

            $.each(response,function(i,row){

                $('#employee_select').append(
                    '<option value="'+row.id+'" data-employee=\''+
                    JSON.stringify(row)+
                    '\'>'+

                    row.name+' ('+row.emp_id+')'+

                    '</option>'
                );

            });

        }
    );
}

$('#employee_select').on('change', function(){

    let employee = $(this)
        .find(':selected')
        .data('employee');

    if(!employee){
         $('#addExitFormModal').find('input').val('');
        return;
    }

    $('#employee_id').val(employee.emp_id);

    $('#department_id').val(
        employee.department?.name ?? ''
    );

    $('#designation_id').val(
        employee.designation?.name ?? ''
    );

    $('#reporting_manager').val(
        employee.reporting_manager?.name ?? ''
    );

    $('#joining_date').val(
        employee.joining_date ?? ''
    );

});
$(document).ready(function () {

    // Export
    $('#exportBtn').click(function () {

        let emp_process = $('#filter_emp_process').val();

        let hr_process = $('#filter_hr_process').val();

        let job_type = $('#filter_job_type').val();

        let department_id = $('#filter_department').val();

        let designation_id = $('#filter_designation').val();

        let url =
            "{{ route('offboard.export') }}" +

            '?emp_process=' + emp_process +

            '&hr_process=' + hr_process +

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

            url: "{{ route('offboard.list') }}",

            data: function (d) {
                d.emp_process = $('#filter_emp_process').val() || '';

                d.hr_process = $('#filter_hr_process').val() || '';

                d.job_type = $('#filter_job_type').val() || '';

                d.department_id = $('#filter_department').val() || '';

                d.designation_id = $('#filter_designation').val() || '';

            }

        },

        columns: [
            {data:'DT_RowIndex', name:'DT_RowIndex', orderable:false, searchable:false},
            {data:'employee_name', name:'employee_name'},
            {data:'employee_id', name:'employee_id'},
            {data:'job_type', name:'job_type'},
            {data:'designation', name:'designation'},
            {data:'reporting_manager', name:'reporting_manager'},
            {data:'joining_date', name:'joining_date'},
            {data:'leaving_date', name:'leaving_date'},
            {data:'submission_status', name:'submission_status', orderable:false},
            {data:'hr_process_status', name:'hr_process_status', orderable:false},
            {data:'action', name:'action', orderable:false, searchable:false}
        ]

    });

    // Search
    $('#searchBtn').click(function () {
        table.ajax.reload();
    });

    
    // RESET MODAL FOR ADD
    $('#addexitFormBtn').on('click', function () {
        loadEmployees();
        $('#addExitFormModal').find('input').val('');
        var myModal = new bootstrap.Modal(document.getElementById('addExitFormModal'));
        myModal.show();
    });

    // ADD / UPDATE EMPLOYEE
    $('#createExitFormSubmit').click(function (e) {
        e.preventDefault();
        
        let employee_id = $('#employee_select').val();
        let leaving_date = $('#leaving_date').val();
        
        let formData = {
            
            employee_id: employee_id,
            
            leaving_date: $('#leaving_date').val(),
            
            _token: '{{ csrf_token() }}'
            
        };
        
        // alert();
        let url = '';
        if (!employee_id) {

            Swal.fire({
                icon: 'warning',
                title: 'Employee Required',
                text: 'Please select an employee.'
            });

            return;
        }

        if (!leaving_date) {

            Swal.fire({
                icon: 'warning',
                title: 'Leaving Date Required',
                text: 'Please select a leaving date.'
            });

            return;
        }

        if (employee_id != '') {
            url = "{{ route('offboard.add') }}";
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

                    $('#addExitFormModal').modal('hide');

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
        }

    });

    $(document).on('click', '.viewBtn', function () {

        let id = $(this).data('id');

        $.get(
            "{{ url('offboard/view') }}/" + id,
            function (res) {

                if(res.emp_process == 'pending'){

                    loadPendingView(res);

                }else{

                    loadStepperView(res);

                }

                new bootstrap.Modal(
                    document.getElementById('viewOffboardModal')
                ).show();

            }
        );

    });

});

function loadPendingView(data)
{
    // alert(1);
    let html = `

       

        <div class="modal-body">

            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex align-items-center">

                        <!-- Profile Image -->
                        <div class="me-3">
                            <img src="${data.employee.photo_url ?? 'default-avatar.png'}"
                                alt="Profile"
                                class="rounded-circle border"
                                width="60"
                                height="60"
                                style="object-fit: cover;">
                        </div>

                        <!-- Employee Details -->
                        <div>
                            <h5 class="mb-0">${data.employee.name}</h5>
                            <small class="text-muted">
                                ${data.employee.designation?.name ?? ''}
                            </small><br>
                            <small class="text-muted">
                                ${data.employee.emp_id ?? ''}
                            </small>
                        </div>

                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <h6><strong>General Information</strong></h6>
                <div class="col-md-6">
                    <label>Department</label>
                    <p class="fw-bold">${data.employee.department.name ?? '-'}</p>
                </div>

                <div class="col-md-6">
                    <label>Reporting Manager</label>
                    <p class="fw-bold">${data.employee.reporting_manager?.name ?? '-'}</p>
                </div>

                <div class="col-md-6">
                    <label>Date of Joining</label>
                    <p class="fw-bold">${data.employee.joining_date ?? '-'}</p>
                </div>

                <div class="col-md-6">
                    <label>Employee Submission</label><br>
                    <span class="badge bg-warning">
                        Pending
                    </span>
                </div>

            </div>

        </div>

    `;

    $('#viewModalContent').html(html);
}

function loadStepperView(data)
{
    let html = `

            <div class="modal-content border-0 shadow-none rounded-0">
                <div class="modal-body">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <img src="${data.employee.photo_url ?? 'default-avatar.png'}"
                                alt="Profile"
                                class="rounded-circle border mr-3"
                                width="60"
                                height="60"
                                style="object-fit: cover;">

                        <div class="ml-2">
                            <h6 class="employee-name fw-bold">${data.employee.name}</h6>
                            <div class="employee-role"> ${data.employee.designation?.name ?? ''}</div>
                            <div class="employee-id"> ${data.employee.emp_id ?? ''}</div>
                        </div>
                    </div>
                    <hr>
                    <div id="step1">
                        <div class="section-title fw-bold  mb-4">
                            General Information
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="label">Department</div>
                                <div class="value fw-bold">${data.employee.department.name ?? '-'}</div>
                            </div>

                            <div class="col-md-4">
                                <div class="label">Reporting Manager</div>
                                <div class="value fw-bold">${data.employee.reporting_manager?.name ?? '-'}</div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="label">Date of Joining</div>
                                <div class="value fw-bold">${data.employee.joining_date ?? '-'}</div>
                            </div>

                            <div class="col-md-4">
                                <div class="label">Last Working Day</div>
                                <div class="value fw-bold">${data.leaving_date ?? '-'}</div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="label">Type of Separation</div>
                                <div class="value fw-bold">${data.leaving_type ?? '-'}</div>
                            </div>

                            <div class="col-md-4">
                                <div class="label">Reason for Leaving</div>
                                <div class="value fw-bold">${data.reason ?? '-'}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="label">Additional Comments</div>
                            <div class="value fw-bold">${data.additional_comments ?? '-'}</div>
                        </div>
                        <div class="mt-4 d-flex gap-2">

                            <button class="btn btn-secondary btn-custom" data-bs-dismiss="modal">
                                Cancel
                            </button>

                            <button class="btn btn-primary btn-custom" onclick="showStep(2)">
                                Next
                            </button>
                        </div>
                    </div>
                    <div id="step2" style="display:none">
                        <div class="section-title fw-bold mb-4">
                            Exit Interview Feedbacks
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="label">
                                    What did you like most about working here?
                                </div>
                                <div class="value fw-bold">
                                    ${data.feedback ?? '-'}
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="label">
                                    What could we improve?
                                </div>
                                <div class="value fw-bold">
                                    ${data.improvements ?? '-'}
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="label">
                                    Overall Experience
                                </div>
                                <div class="value fw-bold">
                                     ${data.experience ?? '-'}
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="label">
                                    Would you recommend this company?
                                </div>
                                <div class="value fw-bold">
                                     ${data.recommend_company ?? '-'}
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="label">
                                    Suggestion
                                </div>
                                <div class="value fw-bold">
                                    ${data.suggestions ?? '-'}
                                </div>
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-secondary btn-custom" onclick="showStep(1)">
                                    Previous
                                </button>

                                <button class="btn btn-primary" onclick="showStep(3)">
                                    Next
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="step3" style="display:none">
                        <div class="section-title fw-bold mb-4">
                            Knowledge Transfer
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="label">
                                    Handover Completed
                                </div>

                                <div class="value fw-bold">
                                     ${data.knowledge_transfer ?? '-'}
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="label">
                                    Handover Details:
                                </div>

                                <div class="value fw-bold">
                                    ${data.handover_details ?? '-'}
                                </div>
                            </div>
                            

                            <div class="col-md-12"><hr></div>
                            <div class="col-md-6 mb-3">
                                
                                <div class="label">
                                    Declaration
                                </div>
                                <div class="value fw-bold">
                                    I confirm that all company assets have been returned and no dues are pending.
                                </div>
                                <div class="label mt-2">
                                    Signature
                                </div>
                                <div class="value fw-bold">
                                   ${
                                    data.signature
                                        ? `
                                        <button class="btn btn-sm btn-primary mt-2"
                                            onclick="viewSignature('${data.signature}')">
                                            View Signature
                                        </button>
                                        <a href="${data.signature}"
                                        download
                                        class="btn btn-success btn-sm mt-2">
                                            Download Signature
                                        </a>
                                        `
                                        : ''
                                }
                                </div>
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-secondary" onclick="showStep(2)">
                                    Previous
                                </button>

                                <button class="btn btn-primary" onclick="showStep(4)">
                                    Next
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="step4" style="display:none">
                        <div class="section-title fw-bold mb-4">Asset Clearance</div>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Laptop Returned</label><br>

                                ${
                                    data.hr_process !== "completed"
                                        ? `
                                            <input type="radio" name="asset_clearance" value="Yes"> Yes
                                            <input type="radio" name="asset_clearance" value="No"> No
                                        `
                                        : `${data.asset_clearance ?? '-'}`
                                }
                            </div>

                            <div class="col-md-4">
                                <label>ID Card Returned</label><br>
                                 ${
                                    data.hr_process !== "completed"
                                        ? `
                                            <input type="radio" name="id_card_returned" value="Yes"> Yes
                                            <input type="radio" name="id_card_returned" value="No"> No
                                        `
                                        : `${data.id_card_returned ?? '-'}`
                                }
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mt-2">
                                <label>Access Card Returned</label><br>
                                ${
                                    data.hr_process !== "completed"
                                        ? `
                                            <input type="radio" name="access_card_returned" value="Yes"> Yes
                                            <input type="radio" name="access_card_returned" value="No"> No
                                        `
                                        : `${data.access_card_returned ?? '-'}`
                                }
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>Other Assets</label>
                                <input class="form-control">
                            </div>
                        </div>
                        <hr>
                        <div class="section-title fw-bold mb-4">IT & Access Revocation</div>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Email Disabled</label><br>
                                ${
                                    data.hr_process !== "completed"
                                        ? `
                                            <input type="radio" name="email_disabled" value="Yes"> Yes
                                            <input type="radio" name="email_disabled" value="No"> No
                                        `
                                        : `${data.email_disabled ?? '-'}`
                                }
                            </div>

                            <div class="col-md-4">
                                <label>System Access Revoked</label><br>
                                ${
                                    data.hr_process !== "completed"
                                        ? `
                                            <input type="radio" name="system_access_revoked" value="Yes"> Yes
                                            <input type="radio" name="system_access_revoked" value="No"> No
                                        `
                                        : `${data.system_access_revoked ?? '-'}`
                                }
                            </div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <label>Data Backup Completed</label><br>
                            ${
                                    data.hr_process !== "completed"
                                        ? `
                                            <input type="radio" name="data_backup_completed" value="Yes"> Yes
                                            <input type="radio" name="data_backup_completed" value="No"> No
                                        `
                                        : `${data.data_backup_completed ?? '-'}`
                                }
                        </div>
                        <div class="mt-4">
                            <button class="btn btn-secondary" onclick="showStep(3)">
                                Previous
                            </button>

                            <button class="btn btn-primary" onclick="showStep(5)">
                                Next
                            </button>
                        </div>
                    </div>
                    <div id="step5" style="display:none">
                        <div class="section-title fw-bold mb-4">Finance Clearance</div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Salary Settled</label><br>
                                ${
                                    data.hr_process !== "completed"
                                        ? `
                                            <input type="radio" name="salary_settled" value="Yes"> Yes
                                            <input type="radio" name="salary_settled" value="No"> No
                                        `
                                        : `${data.salary_settled ?? '-'}`
                                }
                            </div>
                            <div class="col-md-6">
                                <label>Notice Period Recovery</label><br>
                                 ${
                                    data.hr_process !== "completed"
                                        ? `
                                            <input type="radio" name="notice_period_completed" value="Yes"> Yes
                                            <input type="radio" name="notice_period_completed" value="No"> No
                                        `
                                        : `${data.notice_period_completed ?? '-'}`
                                }
                            </div>
                            <div class="col-md-6 mt-2">
                                <label>Reimbursement Clearance</label><br>
                                 ${
                                    data.hr_process !== "completed"
                                        ? `
                                            <input type="radio" name="reimbursement_settled" value="Yes"> Yes
                                            <input type="radio" name="reimbursement_settled" value="No"> No
                                        `
                                        : `${data.reimbursement_settled ?? '-'}`
                                }
                            </div>


                            <div class="col-md-6 mt-2">
                                <label>Others</label><br>
                                 ${
                                    data.hr_process !== "completed"
                                        ? `
                                            <input type="text" name="other_finance_notes" class="form-control">
                                        `
                                        : `${data.other_finance_notes ?? '-'}`
                                }
                            </div>
                        </div>
                        <hr>
                        <div class="section-title fw-bold mb-4">HR Clearance</div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Exit Interview Conducted</label><br>
                                ${
                                    data.hr_process !== "completed"
                                        ? `
                                            <input type="radio" name="exit_interview_completed" value="Yes"> Yes
                                            <input type="radio" name="exit_interview_completed" value="No"> No
                                        `
                                        : `${data.exit_interview_completed ?? '-'}`
                                }
                            </div>
                            <div class="col-md-6">
                                <label>Documents Collected</label><br>
                                ${
                                    data.hr_process !== "completed"
                                        ? `
                                            <input type="radio" name="documents_collected" value="Yes"> Yes
                                            <input type="radio" name="documents_collected" value="No"> No
                                        `
                                        : `${data.documents_collected ?? '-'}`
                                }
                            </div>
                            <div class="col-md-6 mt-3">
                                <label>Status</label>
                                ${
                                    data.hr_process !== "completed"
                                        ? `
                                            <select class="form-select" name="hr_process">
                                                <option>Select Status</option>
                                                <option>Completed</option>
                                            </select>
                                        `
                                        : `${data.hr_process ?? '-'}`
                                }
                                
                            </div>
                        </div>
                        <div class="mt-4">
                            <button class="btn btn-secondary btn-custom" onclick="showStep(4)">
                                Previous
                            </button>
                             ${
                                    data.hr_process !== "completed"
                                        ? `
                            <button class="btn btn-success btn-custom" id="hrProcessButton" data-id="${data.id}">
                                Submit
                            </button>`
                                        : ``
                                }
                        </div>
                    </div>
                </div>
            </div>
        

    `;

    $('#viewModalContent').html(html);
}

function showStep(step) {
            for (let i = 1; i <= 5; i++) {
                const el = document.getElementById('step' + i);
                if (el) {
                    el.style.display = 'none';
                }
            }
            document.getElementById('step' + step).style.display = 'block';
        }

        $(document).on('click', '#hrProcessButton', function () {

    let offboardId = $(this).data('id');

    let requiredRadios = [
        'asset_clearance',
        'id_card_returned',
        'access_card_returned',
        'email_disabled',
        'system_access_revoked',
        'data_backup_completed',
        'salary_settled',
        'notice_period_completed',
        'reimbursement_settled',
        'exit_interview_completed',
        'documents_collected'
    ];

    let formData = {
        _token: '{{ csrf_token() }}',
        id: offboardId
    };

    let valid = true;

    $.each(requiredRadios, function(index, name){

        let value = $('input[name="'+name+'"]:checked').val();

        if(!value){
            valid = false;
            return false;
        }

        formData[name] = value;
    });

    if(!valid){

        Swal.fire({
            icon: 'warning',
            title: 'Validation Error',
            text: 'Please select all radio button values.'
        });

        return;
    }

    let hrProcess = $('select[name="hr_process"]').val();

    if(!hrProcess){

        Swal.fire({
            icon: 'warning',
            title: 'Validation Error',
            text: 'Please select HR Process Status.'
        });

        return;
    }

    formData.hr_process = hrProcess;
    formData.other_finance_notes =
        $('input[name="other_finance_notes"]').val();

    $.ajax({

        url: "{{ route('offboard.hr-process-update') }}",

        type: 'POST',

        data: formData,

        success: function(response){
 $('#viewOffboardModal').modal('hide');
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: response.message
            });

           

            $('#employeeTable')
                .DataTable()
                .ajax
                .reload();

        },

        error: function(xhr){

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: xhr.responseJSON?.message ??
                      'Something went wrong'
            });

        }

    });

});
</script>