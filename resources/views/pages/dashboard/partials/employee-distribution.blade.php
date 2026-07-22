@php
    $departmentId = session('department_id');

if($departmentId == 1 || $departmentId == 2){
    
@endphp
<div class="col-lg-6 g-3">
    <div class="card shadow-sm rounded-4 h-100">

        <div class="card-header d-flex justify-content-between align-items-center border-0">
            <h6 class="mb-0">Employee Distribution</h6>

            {{-- <select class="form-select form-select-sm w-auto">
                <option>All Departments</option>
            </select> --}}
        </div>

        <div class="card-body">

            <div class="row align-items-start">
                <div class="col-md-6">
                    <div style="height:250px;">
                        <canvas id="employeeDistributionChart"></canvas>
                    </div>
                </div>
                <div class="col-md-6">
                   <div id="departmentLegend"></div>
                </div>

            </div>

        </div>

    </div>
</div>

@php
}else {
@endphp
<div class="col-lg-6 g-3">
    <div class="card rounded-4 h-100">

        <div class="card-header d-flex justify-content-between align-items-center border-0">
            <h6 class="mb-0">Projects</h6>

           
        </div>

        <div class="p-3">

            <table class="table table-striped table-hover align-middle w-100 data-table">

                <thead>
                    <tr>
                        <th>Project Name</th>
                        <th width="55%">Progress</th>
                    </tr>
                </thead>

                <tbody id="employeeProjectsBody">

                </tbody>

            </table>

        </div>

    </div>
</div>

@php
}
@endphp
