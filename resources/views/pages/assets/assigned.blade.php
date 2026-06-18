<div class="content-wrapper p-3">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">Assigned Assets</h3>
        </div>

        <div>

            <button class="btn btn-success me-2" id="exportBtn">
                <i class="bi bi-file-earmark-excel me-1"></i>
                Export
            </button>
            <button
                class="btn btn-success me-2"
                id="addAssetBtn"
                data-bs-toggle="modal"
                data-bs-target="#assetModal">
                Assign Asset
            </button>
            {{-- <button class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#assetRequestModal">

                <i class="bi bi-plus-lg me-1"></i>
                Asset Request

            </button> --}}

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

                {{-- <div class="col-md-3">

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

                </div> --}}

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
                        <th>Name</th>
                        <th>ID</th>
                        <th>Laptop Brand</th>
                        <th>Asset No</th>
                        <th>Vendor</th>
                        <th>Mouse Code</th>
                        <th>Serial No</th>
                        <th>RAM</th>
                        <th>System Config</th>
                        <th>OS Version</th>
                        <th>Allocated At</th>
                        <th>Action</th>

                    </tr>

                </thead>

            </table>

        </div>

    </div>

</div>


<div class="modal fade"
     id="assetModal">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5>Assign Asset</h5>

            </div>

            <div class="modal-body">

                <form id="assetForm">

                    <div class="row">
                        <input type="hidden" name="id" id="asset_id">
                        <div class="col-md-6 mb-3">
                            <label>Department</label>
                            <select name="department" id="department_id" class="form-select">
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
                        <div class="col-md-6 mb-3">
                            <label>Employee</label>
                            <select name="employee_id" class="form-select" id="employee">
                                
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Laptop Brand</label>
                            <input type="text"
                                   name="laptop_brand"
                                   class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Asset Number</label>
                            <input type="text"
                                   name="asset_no"
                                   class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Vendor</label>
                            <input type="text"
                                   name="vendor"
                                   class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Mouse Code</label>
                            <input type="text"
                                   name="mouse_code"
                                   class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Serial Number</label>
                            <input type="text"
                                   name="serial_no"
                                   class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>RAM</label>
                            <input type="text"
                                   name="ram"
                                   class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>OS Version</label>
                            <input type="text"
                                   name="os_version"
                                   class="form-control">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>System Configuration</label>
                            <textarea
                                name="sys_config"
                                class="form-control"></textarea>
                        </div>

                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        Save Asset

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>


<div class="modal fade" id="transferModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="assetModalTitle">Assign Asset</h5>
            </div>

            <form id="transferForm">
                
                <input type="hidden"
                       name="asset_id"
                       id="transfer_asset_id">

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Department</label>
                        <select
                            class="form-select"
                            id="transfer_department">

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

                    <div class="mb-3">
                        <label>Employee</label>

                        <select
                            name="employee_id"
                            id="transfer_employee"
                            class="form-select">
                        </select>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="submit"
                        class="btn btn-primary">

                        Transfer

                    </button>

                </div>

            </form>

        </div>
    </div>
</div>
<script>
  var table = $('#assetTable').DataTable({

    processing:true,
    serverSide:true,
    
    ajax:{
        
        url:"{{ route('assigned-assets.list') }}",
        data: function (d) {
            d.department_id = $('#filter_department').val();
        }
    },

    columns:[

        {data:'DT_RowIndex', name:'DT_RowIndex', searchable: false,
        orderable: false},
        {data:'employee_name'},
        {data:'employee_code'},
        {data:'laptop_brand'},
        {data:'asset_no'},
        {data:'vendor'},
        {data:'mouse_code'},
        {data:'serial_no'},
        {data:'ram'},
        {data:'sys_config'},
        {data:'os_version'},
        {data:'created_at'},
        {data:'action'}
    ]
});
$('#searchBtn').click(function(){

    table.ajax.reload();

});
$(document).on('click', '.returnBtn', function () {

    let id = $(this).data('id');

    Swal.fire({
        title: 'Return Asset?',
        text: 'This asset will be marked as inactive.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Return'
    }).then((result) => {

        if(result.isConfirmed){

            $.ajax({
                url: "{{ route('assigned-assets.return') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function(res){

                    Swal.fire(
                        'Returned!',
                        res.message,
                        'success'
                    );

                    table.ajax.reload(null,false);
                }
            });

        }
    });

});

$(document).on('click', '.transferBtn', function(){

    $('#transfer_asset_id').val(
        $(this).data('id')
    );

    $('#transferModal').modal('show');

});

$('#department_id').change(function(){

    let department_id = $(this).val();

    $.get(
        "{{ route('employees.department') }}",
        {
            department_id: department_id
        },
        function(res){

            $('#employee').html('');

            $.each(res,function(i,item){

                $('#employee').append(
                    `<option value="${item.id}">
                        ${item.name}
                    </option>`
                );

            });

        }
    );

});
$('#transfer_department').change(function(){

    let department_id = $(this).val();

    $.get(
        "{{ route('employees.department') }}",
        {
            department_id: department_id
        },
        function(res){

            $('#transfer_employee').html('');

            $.each(res,function(i,item){

                $('#transfer_employee').append(
                    `<option value="${item.id}">
                        ${item.name}
                    </option>`
                );

            });

        }
    );

});
$('#transferForm').submit(function(e){

    e.preventDefault();

    $.ajax({

        url:"{{ route('assigned-assets.transfer') }}",
        type:"POST",
        data: $(this).serialize() +
              '&_token={{ csrf_token() }}',

        success:function(res){

            $('#transferModal').modal('hide');

            Swal.fire(
                'Success',
                res.message,
                'success'
            );

            table.ajax.reload(null,false);
        }
    });

});
$('#exportBtn').click(function(){

    let department_id =
        $('#filter_department').val();

    window.location =
        "{{ route('assigned-assets.export') }}"
        + '?department_id='
        + department_id;
});
$('#addAssetBtn').click(function(){

    $('#assetForm')[0].reset();

    $('#asset_id').val('');
    

    $('#employee').html('');

    $('#assetModalTitle').text('Assign Asset');

});
$('#assetForm').submit(function(e){

    e.preventDefault();

    $.ajax({

        url: "{{ route('assets.assign') }}",
        type: "POST",
        data: $(this).serialize() +
              '&_token={{ csrf_token() }}',

        success: function(res){

            if(!res.status){

                Swal.fire(
                    'Already Assigned',
                    res.message,
                    'warning'
                );

                return;
            }

            $('#assetModal').modal('hide');

            Swal.fire(
                'Success',
                res.message,
                'success'
            );

            table.ajax.reload(null,false);
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
$(document).on('click','.editBtn',function(){

    let id = $(this).data('id');

    $.get(
        "{{ url('asset-details') }}/"+id,
        function(res){

            $('#asset_id').val(res.id);

            $('#assetModalTitle')
                .text('Edit Asset Assign');

            $('#department_id')
                .val(res.employee.department_id)
                .trigger('change');

            setTimeout(function(){

                $('#employee')
                    .val(res.employee_id);

            },500);

            $('[name="laptop_brand"]')
                .val(res.laptop_brand);

            $('[name="asset_no"]')
                .val(res.asset_no);

            $('[name="vendor"]')
                .val(res.vendor);

            $('[name="mouse_code"]')
                .val(res.mouse_code);

            $('[name="serial_no"]')
                .val(res.serial_no);

            $('[name="ram"]')
                .val(res.ram);

            $('[name="os_version"]')
                .val(res.os_version);

            $('[name="sys_config"]')
                .val(res.sys_config);

            $('#assetModal').modal('show');

        }
    );

});
</script>