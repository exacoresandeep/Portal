<div class="content-wrapper p-3">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">Onboard Employee</h3>
        </div>
        <div>
            <button class="btn btn-success">
                <i class="bi bi-file-earmark-excel me-1"></i>
                Export
            </button>
            <button class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>
                Add Employee
            </button> 
        </div>

    </div>

    

    <div class="table-responsive">

       <table class="table table-striped table-hover align-middle w-100 data-table"
       id="employeeTable">

            <thead class="table-light">

                <tr>

                    <th>Sl No.</th>

                    <th>Employee ID</th>

                    <th>Employee Name</th>

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

    $('#employeeTable').DataTable({

        processing: true,

        serverSide: true,

        ajax: "{{ route('onboard.list') }}",

        columns: [

            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },

            {
                data: 'emp_id',
                name: 'emp_id'
            },

            {
                data: 'employee_name',
                name: 'name'
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
                data: 'designation',
                name: 'designation'
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

});

</script>