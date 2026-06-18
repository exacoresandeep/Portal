<div class="content-wrapper p-3">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">Training Phases</h3>
        </div>

        <div>
            
            <button
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#phaseModal">

                <i class="bi bi-plus-lg me-1"></i>
                 Add Phase
            </button>
        </div>

    </div>

    <!-- Filters -->
    <div class="pb-3 mb-3 border-bottom">
        <div class="card-body">

            <div class="row g-3 align-items-end">

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
               id="phaseTable">

            <thead class="table-light">

                <tr>

                    <th>Sl No.</th>

                    <th>Phase Name</th>

                    <th>Focus</th>

                    
                    <th>Department</th>
                    
                    <th>Duration</th>

                    <th width="120">Action</th>

                </tr>

            </thead>

        </table>

    </div>

</div>

<div class="modal fade"
     id="phaseModal">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header">
                <h5>Add Training Phase</h5>
            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-md-6">
                        <label>Department</label>

                        <select
                            class="form-select"
                            id="department_id">

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

                    <div class="col-md-6">
                        <label>Phase Name</label>

                        <input
                            type="text"
                            class="form-control"
                            id="phase_name">
                    </div>

                    <div class="col-md-12 mt-3">
                        <label>Focus</label>

                        <input
                            type="text"
                            class="form-control"
                            id="focus">
                    </div>

                </div>

                <hr>

                <div class="d-flex justify-content-between mb-3">

                    <h6>Topics</h6>

                    <button
                        type="button"
                        class="btn btn-sm btn-success"
                        id="addTopicRow">

                        Add Topic

                    </button>

                </div>

                <table class="table">

                    <thead>
                        <tr>
                            <th>Topic Name</th>
                            <th>Introduction</th>
                            <th>Duration</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody id="topicTableBody"></tbody>

                </table>

            </div>

            <div class="modal-footer">

                <button
                    class="btn btn-primary"
                    id="savePhase">

                    Save

                </button>

            </div>

        </div>

    </div>

</div>

<div class="modal fade" id="viewModal">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">
                <h5>Training Phase Details</h5>
            </div>

            <div class="modal-body" id="viewModalBody">

            </div>

        </div>

    </div>

</div>


<div class="modal fade" id="editModal">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header">
                <h5>Edit Training Phase</h5>
            </div>

            <div class="modal-body">

                <input type="hidden" id="edit_id">

                <div class="row">

                    <div class="col-md-6">
                        <label>Department</label>

                        <select class="form-select" id="edit_department_id">

                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">
                                    {{ $department->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Phase Name</label>

                        <input type="text"
                            class="form-control"
                            id="edit_phase_name">
                    </div>

                    <div class="col-md-12 mt-3">
                        <label>Focus</label>

                        <input type="text"
                            class="form-control"
                            id="edit_focus">
                    </div>

                </div>

                <hr>

                <div class="d-flex justify-content-between mb-3">

                    <h6>Topics</h6>

                    <button type="button"
                            class="btn btn-success btn-sm"
                            id="editAddTopicRow">

                        Add Topic

                    </button>

                </div>

                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th>Topic Name</th>
                            <th>Introduction</th>
                            <th>Duration</th>
                            <th width="80">Action</th>
                        </tr>
                    </thead>

                    <tbody id="editTopicBody"></tbody>

                </table>

            </div>

            <div class="modal-footer">

                <button
                    class="btn btn-success"
                    id="updatePhase">

                    Update

                </button>

            </div>

        </div>

    </div>

</div>


<script>
$('#editAddTopicRow').click(function(){

appendEditTopicRow();

});
$('#addTopicRow').click(function(){

    $('#topicTableBody').append(`

        <tr>

            <td>
                <input type="text"
                    class="form-control topic_name">
            </td>

            <td>
                <input type="text"
                    class="form-control introduction">
            </td>

            <td>
                <input type="number"
                    class="form-control duration">
            </td>

            <td>
                <button
                    class="btn btn-danger removeRow">

                    X

                </button>
            </td>

        </tr>

    `);

});
$(document).on(
    'click',
    '.removeEditRow',
    function(){

        $(this)
            .closest('tr')
            .remove();

    }
);
$('#savePhase').click(function(){

    let topics = [];

    $('#topicTableBody tr').each(function(){

        topics.push({

            topic_name:
                $(this)
                .find('.topic_name')
                .val(),

            introduction:
                $(this)
                .find('.introduction')
                .val(),

            duration:
                $(this)
                .find('.duration')
                .val()

        });

    });

    $.ajax({

        url:
        "{{ route('training.phase.store') }}",

        type: 'POST',

        data: {

            _token:
            '{{ csrf_token() }}',

            department_id:
            $('#department_id').val(),

            phase_name:
            $('#phase_name').val(),

            focus:
            $('#focus').val(),

            status: 'active',

            topics: topics

        },

        success: function(res){

            Swal.fire(
                'Success',
                res.message,
                'success'
            );

            const modal = bootstrap.Modal.getInstance(
                document.getElementById('phaseModal')
            );

            modal.hide();

            $('#department_id').val('');
            $('#phase_name').val('');
            $('#focus').val('');
            $('#topicTableBody').html('');

            table.ajax.reload(null,false);
        }

    });

});
var table = $('#phaseTable').DataTable({

    processing: true,

    serverSide: true,

    ajax: {

        url: "{{ route('training.phase.list') }}",

        data: function(d){

            d.department_id =
                $('#filter_department').val();

        }

    },

    columns: [

        {
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            searchable: false,
            orderable: false
        },

        {
            data: 'phase_name',
            name: 'phase_name'
        },

        {
            data: 'focus',
            name: 'focus'
        },

        {
            data: 'department',
            name: 'department'
        },

        {
            data: 'duration',
            name: 'duration',
            searchable: false
        },

        {
            data: 'action',
            name: 'action',
            searchable: false,
            orderable: false
        }

    ]

});

$('#searchBtn').click(function () {
    table.ajax.reload();
});

$(document).on(
    'click',
    '.viewBtn',
    function(){

        let id = $(this).data('id');

        $.get(
            '/training-phase/view/' + id,
            function(res){

                let html = `

                    <div class="row">

                        <div class="col-md-6">
                            <strong>Department:</strong>
                            ${res.department.name}
                        </div>

                        <div class="col-md-6">
                            <strong>Phase:</strong>
                            ${res.phase_name}
                        </div>

                        <div class="col-md-12 mt-3">
                            <strong>Focus:</strong>
                            ${res.focus}
                        </div>

                    </div>

                    <hr>

                    <h6>Topics</h6>

                    <table class="table table-bordered">

                        <thead>
                            <tr>
                                <th>Topic</th>
                                <th>Introduction</th>
                                <th>Duration</th>
                            </tr>
                        </thead>

                        <tbody>

                `;

                $.each(res.topics,function(i,row){

                    html += `
                        <tr>
                            <td>${row.topic_name}</td>
                            <td>${row.introduction}</td>
                            <td>${row.duration} Week</td>
                        </tr>
                    `;
                });

                html += `
                        </tbody>
                    </table>
                `;

                $('#viewModalBody').html(html);

                new bootstrap.Modal(
                    document.getElementById('viewModal')
                ).show();
            }
        );
    }
);

$(document).on(
    'click',
    '.editBtn',
    function(){

        let id = $(this).data('id');

        $.get(
            '/training-phase/edit/' + id,
            function(res){

                $('#edit_id').val(res.id);

                $('#edit_department_id').val(
                    res.department_id
                );

                $('#edit_phase_name').val(
                    res.phase_name
                );

                $('#edit_focus').val(
                    res.focus
                );

                $('#editTopicBody').html('');

                $.each(res.topics,function(i,row){

                    appendEditTopicRow(
                        row.topic_name,
                        row.introduction,
                        row.duration
                    );

                });

                new bootstrap.Modal(
                    document.getElementById('editModal')
                ).show();
            }
        );
    }
);

$('#updatePhase').click(function(){

    let topics = [];

    $('#editTopicBody tr').each(function(){

        topics.push({

            topic_name:
                $(this)
                .find('.topic_name')
                .val(),

            introduction:
                $(this)
                .find('.introduction')
                .val(),

            duration:
                $(this)
                .find('.duration')
                .val()

        });

    });

    $.ajax({

        url:
        '/training-phase/update/' +
        $('#edit_id').val(),

        type:'POST',

        data:{

            _token:
            '{{ csrf_token() }}',

            department_id:
            $('#edit_department_id').val(),

            phase_name:
            $('#edit_phase_name').val(),

            focus:
            $('#edit_focus').val(),

            topics:
            topics

        },

        success:function(res){

            Swal.fire(
                'Success',
                res.message,
                'success'
            );

            bootstrap.Modal
                .getInstance(
                    document.getElementById('editModal')
                )
                .hide();

            table.ajax.reload(null,false);
        }
    });

});

function appendEditTopicRow(
    topic_name = '',
    introduction = '',
    duration = ''
){

    $('#editTopicBody').append(`

        <tr>

            <td>
                <input type="text"
                       class="form-control topic_name"
                       value="${topic_name}">
            </td>

            <td>
                <input type="text"
                       class="form-control introduction"
                       value="${introduction}">
            </td>

            <td>
                <input type="number"
                       class="form-control duration"
                       value="${duration}">
            </td>

            <td>
                <button type="button"
                        class="btn btn-danger btn-sm removeEditRow">

                    X

                </button>
            </td>

        </tr>

    `);

}
</script>