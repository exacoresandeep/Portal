<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">Resource Utilization</h3>
        </div>
        <div>
            <button type="button"
            class="btn btn-success"
            id="exportBtn">
                <i class="bi bi-file-earmark-excel me-1"></i>
                Export
            </button> 
        </div>

    </div>        
    <div class="card-box">

        <div class="row g-3 mb-4">
            <div class="col-lg col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="summary-icon blue">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="text-muted mb-1">Total Employees</h6>
                                <h4 class="fw-bold text-primary mb-0">85</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="summary-icon green">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="text-muted mb-1">Fully Utilized</h6>
                                <h4 class="fw-bold text-success mb-0">45</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="summary-icon pink">
                                <i class="fa-solid fa-chart-pie"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="text-muted mb-1">Partially Utilized</h6>
                                <h4 class="fw-bold text-danger mb-0">20</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="summary-icon yellow">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="text-muted mb-1">Under Utilized</h6>
                                <h4 class="fw-bold text-warning mb-0">10</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="summary-icon red">
                                <i class="fa-solid fa-user-clock"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="text-muted mb-1">Available / Bench</h6>
                                <h4 class="fw-bold text-danger mb-0">10</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row g-3 align-items-end">
            <div class="col-md-2">
                <label class="form-label">Year</label>
                <select id="year" class="form-select">

                    @for($i = date('Y') - 5; $i <= date('Y') + 2; $i++)

                        <option value="{{ $i }}"
                            {{ $i == date('Y') ? 'selected' : '' }}>
                            {{ $i }}
                        </option>

                    @endfor

                </select>

            </div>

            <div class="col-md-2">
                <label class="form-label">Month</label>
                <select id="month" class="form-select">

                    <option value="">All Months</option>

                    @for($i = 1; $i <= 12; $i++)

                        <option value="{{ $i }}"
                            {{ $i == date('n') ? 'selected' : '' }}>

                            {{ date('F', mktime(0,0,0,$i,1)) }}

                        </option>

                    @endfor

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

            <div class="col-lg-2 col-md-3 col-sm-6">
                <label class="form-label">Billable Status</label>
                <select class="form-select" id="filter_billable">
                    <option selected hidden>Select Status</option>
                    <option value="billable">Billable</option>
                    <option value="non-billable">Non Billable</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-6">
                <label class="form-label">Utilization Status </label>
                <select class="form-select" id="filter_utilization">
                    <option value="">All Utilization</option>

                    <option value="Fully Utilized">
                        🟢 Fully Utilized (90% - 100%)
                    </option>

                    <option value="Optimally Utilized">
                        🟢 Optimally Utilized (70% - 89%)
                    </option>

                    <option value="Partially Utilized">
                        🟡 Partially Utilized (40% - 69%)
                    </option>

                    <option value="Under Utilized">
                        🟠 Under Utilized (1% - 39%)
                    </option>

                    <option value="Available / Bench">
                        🔴 Available / Bench (0%)
                    </option>

                    <option value="Over Allocated">
                        ⚫ Over Allocated (>100%)
                    </option>
                </select>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-6">
                <button class="btn btn-primary w-100" id="searchBtn">
                    <i class="fa-solid fa-magnifying-glass me-2"></i>
                    Search
                </button>
            </div>
            
        </div>
        <div class="px-4"></div>
        <hr>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle w-100 data-table" id="allocationTable">

                <thead class="table-light">

                    <tr>
                        <th>Sl No</th>
                        <th>Employee</th>
                        <th>Department</th>
                        <th>Current Allocation</th>
                        <th>Total Allocation</th>
                        <th>Balance Allocation</th>
                        <th>Billable Status</th>
                        <th>Utilization Status</th>

                    </tr>

                </thead>

            </table>
        </div>
        
    </div>
</div>

<script>
    
    var table = $('#allocationTable').DataTable({

        processing: true,
        serverSide: true,
        searching: true,
        responsive: true,
        autoWidth: false,

        ajax: {

            url: "{{ route('tasks.resource-utilization.list') }}",

            data: function (d) {

                d.year = $('#year').val();
                d.month = $('#month').val();
                d.department = $('#filter_department').val();
                d.billable = $('#filter_billable').val();
                d.utilization = $('#filter_utilization').val();
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
                data: 'employee',
                name: 'employee'
            },

            {
                data: 'department',
                name: 'department'
            },

            {
                data: 'current_allocation',
                name: 'current_allocation',
                orderable: false,
                searchable: false
            },

            {
                data: 'total_allocation',
                name: 'total_allocation',
                className: 'text-center'
            },

            {
                data: 'balance',
                name: 'balance',
                className: 'text-center'
            },

            {
                data: 'billable',
                name: 'billable',
                orderable: false,
                searchable: false
            },
            {
                data: 'status',
                name: 'status',
                orderable: false,
                searchable: false
            }

        ],

        order: [[1, 'asc']]

    });

    $('#searchBtn').click(function () {
        table.ajax.reload();
    });
</script>