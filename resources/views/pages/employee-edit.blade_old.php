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
                        
                    </select>
                </div>

                <!-- Department -->
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <label class="form-label">Department</label>

                    <select id="filter_department"  class="form-select">
                        <option selected value="" >Select department</option>
                        
                    </select>
                </div>

                <!-- Designation -->
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <label class="form-label">Designation</label>

                    <select class="form-select"  id="filter_designation">
                        <option  value=""  selected>Select designation</option>
                       

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




<script>

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