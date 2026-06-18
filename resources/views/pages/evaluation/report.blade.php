<div class="content-wrapper p-4">

    
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">Evaluation Report</h3>
        </div>
        <div>
            <button type="button"
            class="btn btn-success"
            id="exportBtn">
                <i class="bi bi-file-earmark-excel me-1"></i>
                Export
            </button>
            {{-- <button type="button"
            class="btn btn-primary"
            id="assignFormBtn">
            + Assign Form
            </button>  --}}
        </div>

    </div>

    <div class="pb-3 mb-3 border-bottom ">
        <div class="card-body">

            <div class="row g-3 align-items-end">

                <div class="col-md-2">
                    <label class="form-label">Year</label>
                    <select name="year" class="form-select" id="year">
                        @for($year = date('Y') + 1; $year >= 2020; $year--)
                            <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Quater</label>
                    <select name="year" class="form-select" id="quater">
                            <option value="">Select</option>
                            <option value="First Quarter">First Quater</option>
                            <option value="Second Quarter">Second Quater</option>
                            <option value="Third Quarter">Third Quater</option>
                            <option value="Fourth Quarter">Fourth Quater</option>
                    </select>
                </div>

                 <div class="col-lg-2 col-md-3 col-sm-6">
                    <label class="form-label">Department</label>

                    <select class="form-select"  id="department_id">
                        <option  value=""  selected>Select</option>
                        @foreach($departments as $department)

                            <option value="{{ $department->id }}">

                                {{ $department->name }}

                            </option>

                        @endforeach

                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Performance Review</label>
                    <select name="performance_status" id="performance_status" class="form-select">
                            <option value="">Select</option>
                            <option value='Pending'>Pending</option>
                            <option value='Outstanding'>Outstanding</option>
                            <option value='Fully Performing'>Fully Performing</option>
                            <option value='Developing'>Developing</option>
                            <option value='Under Performing'>Under Performing</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Submission Status</label>
                    <select name="submission_status" id="submission_status" class="form-select">
                            <option value="">Select</option>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                    </select>
                </div>    
                <div class="col-md-2">
                    <button id="searchBtn" class="btn btn-primary">
                        Search
                    </button>
                </div>

            </div>
        </div>
    </div>

            <table
                id="evaluationTable"
                class="table table-striped table-hover align-middle w-100 data-table">

                <thead>
                    <tr>
                        <th>Sl No.</th>
                        <th>Employee Name</th>
                        <th>Employee ID</th>
                        <th>Form Name</th>
                        <th>Department</th>
                        <th>Submitted Date</th>
                        <th>Employee Score</th>
                        <th>Assessment Score</th>
                        <th>Performance Review</th>
                        <th>Submission Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>

</div>

<div class="modal fade"
     id="viewReportModal"
     tabindex="-1">

    <div class="modal-dialog custom-modal modal-dialog-scrollable">

        <div class="modal-content">

            <div class="modal-header">

                <div>
                    <h5 class="mb-1 fw-bold" id="employeeNameHeading"></h5>

                    <small class="text-muted">
                        Review and evaluate employee performance submissions.
                    </small>
                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <input
                    type="hidden"
                    id="evaluation_assign_id">

                <div class="row mb-4">

                    <div class="col-md-3">

                        <small class="text-muted">
                            Employee Name
                        </small>

                        <div
                            class="fw-bold"
                            id="employeeName">
                        </div>

                    </div>

                    <div class="col-md-3">

                        <small class="text-muted">
                            Designation
                        </small>

                        <div
                            class="fw-bold"
                            id="designation">
                        </div>

                    </div>

                    <div class="col-md-3">

                        <small class="text-muted">
                            Date Of Joining
                        </small>

                        <div
                            class="fw-bold"
                            id="joiningDate">
                        </div>

                    </div>

                    <div class="col-md-3">

                        <small class="text-muted">
                            Submitted Date
                        </small>

                        <div
                            class="fw-bold"
                            id="submittedDate">
                        </div>

                    </div>

                </div>

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th width="5%">
                                Sl No.
                            </th>

                            <th width="18%">
                                Evaluation Criteria
                            </th>

                            <th width="22%">
                                Sub Points
                            </th>

                            <th width="25%">
                                Justification
                            </th>

                            <th>Employee Score</th>
                            <th>Evaluation Score</th>

                            <th width="15%">
                                Total Score
                            </th>

                        </tr>

                    </thead>

                    <tbody id="evaluationBody">
                    </tbody>

                    <tfoot>

                        <tr>

                            <th
                                colspan="4"
                                class="text-end">
                                Total Points
                            </th>
                            <th
                                id="max_employee_score"
                                class="fw-bold text-center"">
                                0
                            </th>

                            <th>

                                <input
                                    type="text"
                                    readonly
                                    id="obtained_total"
                                    class="form-control fw-bold"
                                    value="0">

                            </th>

                            <th
                                id="max_total_score"
                                class="fw-bold text-center"">
                                0
                            </th>

                        </tr>

                    </tfoot>

                </table>

                <hr>

                <div class="row">

                    <div class="col-md-4">

                        <label class="form-label">
                            Performance Status
                        </label>

                        <select
                            class="form-select"
                            id="review">

                            <option value="">
                                Select Performance Status
                            </option>

                            <option value="Outstanding">
                                Outstanding
                            </option>

                            <option value="Fully Performing">
                                Fully Performing
                            </option>

                            <option value="Developing">
                                Developing
                            </option>

                            <option value="Under Performing">
                                Under Performing
                            </option>

                        </select>

                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Cancel
                </button>

                <button
                    type="button"
                    class="btn btn-primary"
                    id="saveReviewBtn">

                    Submit

                </button>

            </div>

        </div>

    </div>

</div>


<script>
    $('#exportBtn').click(function(){

        let url =
            "{{ route('evaluation.report.export') }}" +

            '?year=' + $('#year').val() +

            '&quater=' + $('#quater').val() +

            '&department_id=' + $('#department_id').val() +

            '&performance_status=' +
            $('select[name="performance_status"]').val() +

            '&submission_status=' +
            $('select[name="submission_status"]').val();

        window.location.href = url;
    });
var table = $('#evaluationTable').DataTable({

    processing:true,
    serverSide:true,

    ajax:{
        url:"{{ route('evaluation.report.list') }}",

        data:function(d){

            d.year = $('#year').val();

            d.quater = $('#quater').val();

            d.department_id =
                $('#department_id').val();

            d.performance_status =
                $('select[name="performance_status"]').val();

            d.submission_status =
                $('select[name="submission_status"]').val();
        }
    },

    columns:[

        {
            data:'DT_RowIndex',
            searchable:false,
            orderable:false
        },

        {
            data:'employee_name'
        },

        {
            data:'employee_code'
        },

        {
            data:'form_name'
        },

        {
            data:'department_name'
        },

        {
            data:'submitted_date'
        },

        {
            data:'employee_score'
        },
        {
            data:'assessment_score'
        },

        {
            data:'performance_review'
        },

        {
            data:'submission_status'
        },

        {
            data:'action',
            searchable:false,
            orderable:false
        }

    ]
});

$('#searchBtn').click(function(e){

    e.preventDefault();

    table.ajax.reload();

});

$(document).on(
    'input',
    '.assessment_mark',
    function(){

        let max =
            parseInt(
                $(this).data('max')
            );

        let value =
            parseInt(
                $(this).val()
            ) || 0;

        if(value > max){

            $(this).val(max);

            value = max;
        }

        let total = 0;

        $('.assessment_mark').each(function(){

            total +=
                parseInt(
                    $(this).val()
                ) || 0;

        });

        $('#obtained_total').val(total);

    }
);
$(document).on(
    'click',
    '.viewBtn',
    function(){

        let id =
            $(this).data('id');

        $.get(
            "{{ url('evaluation-report-view') }}/"+id,

            function(res){

                $('#evaluation_assign_id')
                    .val(res.id);

                $('#employeeNameHeading')
                    .text(res.employee.name);

                $('#employeeName')
                    .text(res.employee.name);

                $('#designation')
                    .text(
                        res.employee.designation?.name ?? '-'
                    );

                $('#joiningDate')
                    .text(
                        res.employee.formatted_joining_date ?? '-'
                    );

                $('#submittedDate')
                    .text(
                        res.formatted_submitted_date
                    );

                let html = '';

                let employeeTotal = 0;
                let evaluationTotal = 0;
                let maxTotal = 0;

                $.each(
                    res.form.questions,
                    function(index, question){

                        maxTotal += parseInt(question.marks);

                        let employeeMark =
                            res.marks?.[question.id] || 0;

                        employeeTotal +=
                            parseInt(employeeMark);

                        let evaluationMark =
                            res.assessment_marks?.[question.id] || 0;

                        evaluationTotal +=
                            parseInt(evaluationMark);

                        let justification =
                            res.justifications?.[question.id] || '';

                        let subpoints = '<ul class="mb-0">';

                        let points = JSON.parse(
                            question.subpoints
                        );

                        $.each(points,function(i,item){

                            subpoints +=
                                '<li>'+item+'</li>';

                        });

                        subpoints += '</ul>';

                        html += `
                            <tr>

                                <td>
                                    ${index+1}
                                </td>

                                <td>
                                    ${question.question}
                                </td>

                                <td>
                                    ${subpoints}
                                </td>

                                <td>
                                    ${justification}
                                </td>

                                <td class="text-center">

                                    ${employeeMark}

                                </td>

                                <td>

                                    <input
                                        type="number"
                                        class="form-control assessment_mark"
                                        data-question="${question.id}"
                                        data-max="${question.marks}"
                                        min="0"
                                        max="${question.marks}"
                                        value="${evaluationMark}">

                                </td>

                                <td class="text-center">

                                    ${question.marks}

                                </td>

                            </tr>
                        `;
                    }
                );
                $('#evaluationBody').html(html);    
                $('#max_total_score').text(maxTotal);

                $('#max_employee_score').text(employeeTotal);

                $('#obtained_total').val(evaluationTotal);

                new bootstrap.Modal(
                    document.getElementById(
                        'viewReportModal'
                    )
                ).show();

            }
        );
    }
);
$('#saveReviewBtn').click(function () {

    let assessmentMarks = {};

    $('.assessment_mark').each(function () {

        assessmentMarks[
            $(this).data('question')
        ] = $(this).val();

    });

    $.ajax({

        url: "{{ route('evaluation.report.review') }}",

        type: "POST",

        data: {

            _token: $('meta[name="csrf-token"]').attr('content'),

            id: $('#evaluation_assign_id').val(),

            assessment_marks: assessmentMarks,

            review: $('#review').val()

        },

        success: function (res) {

            if (res.status) {

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: res.message
                });

                $('#viewReportModal').modal('hide');

                table.ajax.reload();

            } else {

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: res.message
                });

            }
        }

    });

});
</script>