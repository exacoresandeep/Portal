<div class="content-wrapper p-3">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">Asset Requests</h3>
        </div>

        <div>

            <button class="btn btn-success me-2" id="exportBtn">
                <i class="bi bi-file-earmark-excel me-1"></i>
                Export
            </button>

            <button class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#assetRequestModal">

                <i class="bi bi-plus-lg me-1"></i>
                Asset Request

            </button>

        </div>

    </div>

    <div class="mb-4">

        <div class="card-body">

            <div class="row g-3 align-items-end">

                <div class="col-md-3">

                    <label class="form-label">
                        Department
                    </label>

                    <select class="form-select"
                            id="filter_department">

                        <option value="">
                            All Departments
                        </option>

                        @foreach($departments as $department)

                            <option value="{{ $department->id }}">
                                {{ $department->name }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-3">

                    <label class="form-label">
                        Request Status
                    </label>

                    <select class="form-select"
                            id="filter_request_status">

                        <option value="">
                            All Status
                        </option>

                        <option value="Onprogress">
                            On Progress
                        </option>

                        <option value="Done">
                            Completed
                        </option>

                    </select>

                </div>

                <div class="col-md-3">

                    <label class="form-label">
                    Status
                    </label>

                    <select class="form-select"
                            id="filter_status">

                        <option value="">
                            All
                        </option>

                        <option value="active">
                            Active
                        </option>

                        <option value="inactive">
                            Deleted
                        </option>

                    </select>

                </div>

                <div class="col-md-2">

                    <button class="btn btn-primary"
                            id="searchBtn">

                        Search

                    </button>

                </div>

            </div>

        </div>

    </div>

    <div class="">

        <div class="card-body">

            <table class="table table-striped table-hover align-middle w-100 data-table"
                   id="assetTable">

                <thead>

                    <tr>

                        <th>Sl No</th>

                        <th>Department</th>

                        <th>Joining Date</th>

                        <th>Laptop Count</th>

                        <th>Request Status</th>

                        <th>Status</th>

                        <th>Requested Date</th>

                        <th>Actions</th>

                    </tr>

                </thead>

            </table>

        </div>

    </div>

</div>


<!-- Add Asset Request Modal -->
<div class="modal fade"
     id="assetRequestModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content border-0 rounded-4">

            <!-- Header -->
            <div class="modal-header border-0 pb-0">

                <div>
                    <h4 class="fw-bold mb-1">
                        Add Asset Request
                    </h4>

                    <p class="text-muted small mb-0">
                        Enter details to send an asset request and initiate the process.
                    </p>
                </div>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body pt-4">

                <hr>

                <h6 class="fw-semibold mb-4">
                    General Information
                </h6>

                <form id="assetRequestForm">

                    <div class="row g-4">

                        <!-- Department -->
                        <div class="col-md-6">

                            <label class="form-label">
                                Department
                            </label>

                            <select class="form-select"
                                    id="department_id"
                                    name="department_id">

                                <option value="">
                                    Select Department
                                </option>

                                @foreach($departments as $department)

                                    <option value="{{ $department->id }}">
                                        {{ $department->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <!-- Joining Date -->
                        <div class="col-md-6">

                            <label class="form-label">
                                Joining Date
                            </label>

                            <input type="date"
                                   class="form-control"
                                   id="joining_date"
                                   name="joining_date">

                        </div>

                        <!-- Laptop Count -->
                        <div class="col-md-6">

                            <label class="form-label">
                                Laptop Count
                            </label>

                            <input type="number"
                                   min="1"
                                   class="form-control"
                                   id="laptop_count"
                                   name="laptop_count"
                                   value="1">

                        </div>

                    </div>

                    <input type="hidden" id="asset_request_id">

                    <!-- Footer Buttons -->
                    <div class="d-flex gap-3 mt-5">

                        <button type="button"
                                class="btn btn-light px-5"
                                data-bs-dismiss="modal">

                            Cancel

                        </button>

                        <button type="submit"
                                class="btn btn-primary px-5"
                                id="assetSubmitBtn">

                            Send Request

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>
<script>
    $(document).on('click', '.deleteAsset', function () {

    let id = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "This request will be marked as inactive.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Delete'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: "{{ route('asset-request.delete') }}",
                type: "POST",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },

                success: function (response) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });

                    $('#assetTable').DataTable().ajax.reload(null, false);
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
$('#assetRequestForm').submit(function(e){

    e.preventDefault();

    $.ajax({

        url: "{{ route('asset-request.store') }}",

        type: "POST",

        data: {

            department_id: $('#department_id').val(),
            joining_date: $('#joining_date').val(),
            laptop_count: $('#laptop_count').val(),
            _token: '{{ csrf_token() }}'

        },

        success: function(response){

            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: response.message
            });

            $('#assetRequestModal').modal('hide');

            $('#assetTable').DataTable().ajax.reload();
        },

        error: function(xhr){

            let errorMsg = '';

            $.each(xhr.responseJSON.errors, function(key, value){
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
var table  = $('#assetTable').DataTable({

    processing: true,
    serverSide: true,

    ajax: {

        url: "{{ route('assets-requests.list') }}",

        data: function(d){

            d.department_id = $('#filter_department').val();
            d.request_status = $('#filter_request_status').val();
            d.status = $('#filter_status').val();

        }
    },

    columns: [

        {
            data:'DT_RowIndex',
            name:'DT_RowIndex',
            searchable:false,
            orderable:false
        },

        {
            data:'department',
            name:'department'
        },

        {
            data:'joining_date',
            name:'joining_date'
        },

        {
            data:'laptop_count',
            name:'laptop_count'
        },

        {
            data:'request_status',
            name:'request_status'
        },

        {
            data:'status',
            name:'status'
        },

        {
            data:'created_at',
            name:'created_at'
        },

        {
            data:'action',
            name:'action',
            searchable:false,
            orderable:false
        }

    ]

});

$('#searchBtn').click(function(){

    table.ajax.reload();

});

$('#exportBtn').click(function(){

    let department_id = $('#filter_department').val();
    let request_status = $('#filter_request_status').val();
    let status = $('#filter_status').val();

    window.location =
        "{{ route('asset-request.export') }}" +
        "?department_id=" + department_id +
        "&request_status=" + request_status +
        "&status=" + status;

});


</script>