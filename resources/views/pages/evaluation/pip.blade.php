<div class="content-wrapper p-4">

    <div class="cardss">

        <div class="card-headerss mb-4">
            <h3 class="mb-0">
                Performance Improvement Plan (PIP)
            </h3>
        </div>

        <div class="card-bodyss">

            

                <div class="row mb-4">

                    <div class="col-md-3">

                        <label>
                            Department
                        </label>

                        <select name="department" id="department"
                                class="form-select" >

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

                        <label>
                            Year
                        </label>

                        <select name="year"
                                class="form-select" id="year">

                            @for($year = date('Y') + 1; $year >= 2020; $year--)
                                <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor

                        </select>

                    </div>

                    <div class="col-md-2">

                        <label>&nbsp;</label>

                        <button type="submit"
                                class="btn btn-primary d-block w-100" id="searchBtn">

                            Search

                        </button>

                    </div>

                </div>

            

            <div class="table-responsive">

               <table class="table table-striped table-hover align-middle w-100 data-table"
id="pipTable">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Employee ID</th>
                            <th>Employee Name</th>
                            <th>Department</th>
                            <th>Year</th>
                            <th>Review Details</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>

            </div>

        </div>

    </div>

</div>
<script>


$('#searchBtn').click(function(e){

    e.preventDefault();

    table.ajax.reload();

});

    var table = $('#pipTable').DataTable({

        processing: true,
        serverSide: true,

        ajax: {
            url: "{{ route('pip.list') }}",
            data: function (d) {

                d.department = $('#department').val();
                d.year = $('#year').val();

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
                data: 'employee_id',
                name: 'employee_id'
            },
            {
                data: 'employee_name',
                name: 'employee_name'
            },
            {
                data: 'department',
                name: 'department'
            },
            {
                data: 'year',
                name: 'year'
            },
            {
                data: 'review_details',
                name: 'review_details',
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


</script>