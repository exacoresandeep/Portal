<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between mb-4">
        <h4 class="fw-bold">
            Evaluation Forms
        </h4>
        <button
            type="button"
            class="btn btn-primary"
            id="addEvaluationFormBtn">
            + Add Evaluation Form
        </button>
    </div>

    <div class="">
        <div class="card-body">
            <table
                id="evaluationTable"
                class="table table-striped table-hover align-middle w-100 data-table">
                <thead>
                    <tr>
                        <th>Sl No.</th>
                        <th>Form Name</th>
                        <th>Total Marks</th>
                        <th>Total Questions</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade"
     id="evaluationFormModal"
     tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Add Self Evaluation Form</h3>      
                </div>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>              
            </div>

            <div class="modal-body">
                <form id="evaluationForm">
                    <input
                        type="hidden"
                        name="id"
                        id="form_id">
                    <div class="container-fluid">
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Form Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Enter evaluation form name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Total Points</label>
                                <input type="text" class="form-control" id="total_points" placeholder="Auto-generated total" readonly>
                            </div>
                        </div>
                        <h4 class="mb-3">Add Questions</h4>
                        <!--  Container -->
                        <div id="questionsContainer">
                            <!--  1 -->
                            <div class="border rounded p-4 mb-3 bg-white question-form">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0">Question 1</h5>
                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeQuestion(this)">
                                        Remove
                                    </button>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Evaluation Criteria</label>
                                        <input type="text"  name="question[]" class="form-control" placeholder="Enter evaluation criteria">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Points</label>
                                        <input type="number" name="marks[]" class="form-control" placeholder="Enter points">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Sub Points</label>
                                        <textarea class="form-control sub_points" rows="3" name="sub_points[]" placeholder="Enter sub points"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Add Question -->
                        <button type="button" class="btn btn-outline-primary" onclick="addQuestion()">
                            + Add Question
                        </button>
                        <!-- Action Buttons -->
                        <div class="mt-4">
                            <button type="button" class="btn btn-outline-dark" style="width: 120px;" onclick="cancelForm()">
                                Cancel
                            </button>
                            <button type="button" class="btn btn-primary ms-2" style="width: 120px;" onclick="submitForm()">
                                Submit
                            </button>
                        </div>                       
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade"
     id="viewModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="viewFormTitle"></h4>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <small>Form Name</small>
                        <h6 id="viewName"></h6>
                    </div>
                    <div class="col-md-6">
                        <small>Total Points</small>
                        <h6 id="viewMarks"></h6>
                    </div>
                </div>
                <div id="viewQuestions"></div>
            </div>
        </div>
    </div>
</div>
<script>
    function calculateTotalMarks()
    {
        let total = 0;
        $('input[name="marks[]"]').each(function () {
            total += Number($(this).val()) || 0;
        });
        $('#total_points').val(total);
    }

    $(document).on('keyup', 'input[name="marks[]"]', function () {
        calculateTotalMarks();
    });
    $(document).on(
        'keyup change',
        'input[name="marks[]"]',
        function () {
            calculateTotalMarks();
        }
    );
    $(document).on('focus', '.sub_points', function () {
        if ($(this).val().trim() === '') {
            $(this).val('• ');
            this.setSelectionRange(
                this.value.length,
                this.value.length
            );
        }
    });

    $(document).on('keydown', '.sub_points', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            let cursorPos = this.selectionStart;
            let text = $(this).val();
            let before = text.substring(0, cursorPos);
            let after = text.substring(cursorPos);
            let newText = before + '\n• ' + after;
            $(this).val(newText);
            this.selectionStart =
            this.selectionEnd =
            cursorPos + 3;
        }
    });
    var questionCount = 1;

    function addQuestion() {
        questionCount++;
        const container = document.getElementById("questionsContainer");
        const newQuestion = document.createElement("div");
        newQuestion.className =
            "border rounded p-4 mb-3 bg-white question-form";
        newQuestion.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Question ${questionCount}</h5>

                <button type="button"
                    class="btn btn-outline-danger btn-sm"
                    onclick="removeQuestion(this)">
                    Remove
                </button>
            </div>

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Evaluation Criteria</label>

                    <input type="text"
                        name="question[]"
                        class="form-control"
                        placeholder="Enter evaluation criteria">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Points</label>

                    <input type="number"
                        name="marks[]"
                        class="form-control"
                        placeholder="Enter points">
                </div>

                <div class="col-md-12">
                    <label class="form-label">Sub Points</label>

                    <textarea
                        name="sub_points[]"
                        class="form-control sub_points"
                        rows="4"
                        placeholder="Enter sub points"></textarea>
                </div>

            </div>
            `;
        container.appendChild(newQuestion);
    }

    function removeQuestion(button) {
        const questions =
            document.querySelectorAll(".question-form");
        if (questions.length === 1) {
            alert("At least one question is required.");
            return;
        }
        button.closest(".question-form").remove();
        updateQuestionNumbers();
    }

    function updateQuestionNumbers() {
        const questions =
            document.querySelectorAll(".question-form");
        questions.forEach((question, index) => {
            question.querySelector("h5").textContent =
                `Question ${index + 1}`;
        });
        questionCount = questions.length;
    }
</script>
<script>
    $('#addEvaluationFormBtn').click(function(){
        $('#evaluationForm')[0].reset();
        $('#form_id').val('');
        $('#modalTitle').text(
            'Add Evaluation Form'
        );
        $('#evaluationFormModal').modal('show');
    });

    var table = $('#evaluationTable').DataTable({
        processing:true,
        serverSide:true,
        ajax:{
            url:"{{ route('evaluation.forms.list') }}"
        },
        columns:[
            {
                data:'DT_RowIndex',
                searchable:false,
                orderable:false
            },
            {data:'name'},
            {data:'total_marks'},
            {data:'total_questions'},
            {
                data:'action',
                searchable:false,
                orderable:false
            }
        ]
    });
    $(document).on(
        'click',
        '.deleteBtn',
        function(){
            let id = $(this).data('id');
            Swal.fire({
                title:'Delete Form?',
                text:'This action cannot be undone.',
                icon:'warning',
                showCancelButton:true,
                confirmButtonText:'Delete'
            }).then((result)=>{
                if(result.isConfirmed){
                    $.ajax({
                        url:"{{ route('evaluation.forms.delete') }}",
                        type:"POST",
                        data:{
                            _token:"{{ csrf_token() }}",
                            id:id
                        },
                        success:function(res){
                            Swal.fire(
                                'Deleted',
                                res.message,
                                'success'
                            );
                            table.ajax.reload(
                                null,
                                false
                            );
                        }
                    });
                }
            });

    });
    function submitForm()
    {
        $.ajax({
            url: "{{ route('evaluation.forms.store') }}",
            type: "POST",
            data: $('#evaluationForm').serialize(),
            headers: {
                'X-CSRF-TOKEN':
                $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res){
                Swal.fire(
                    'Success',
                    res.message,
                    'success'
                );
                $('#evaluationFormModal').modal('hide');
                table.ajax.reload(null,false);
            },
            error:function(xhr){
                Swal.fire(
                    'Error',
                    'Validation failed',
                    'error'
                );
            }
        });
    }

  $(document).on('click', '.viewBtn', function () {

    let id = $(this).data('id');

    $.get("{{ url('evaluation-form-view') }}/" + id, function (res) {

        $('#viewFormTitle').text(res.name);
        $('#viewName').text(res.name);

        let total = 0;
        let html = '';

        $.each(res.questions, function (index, item) {

            total += parseInt(item.marks) || 0;

            let subpoints = [];

            if (item.subpoints) {
                if (typeof item.subpoints === 'string') {
                    try {
                        subpoints = JSON.parse(item.subpoints);
                    } catch (e) {
                        subpoints = [];
                    }
                } else {
                    subpoints = item.subpoints;
                }
            }

            html += `
                <div class="border-top pt-4 mb-4">

                    <div class="row">

                        <div class="col-md-8">
                            <small>Evaluation Criteria</small>
                            <h6>${item.question}</h6>
                        </div>

                        <div class="col-md-4">
                            <small>Points</small>
                            <h6>${item.marks}</h6>
                        </div>

                    </div>

                    <div class="mt-3">

                        <small>Sub Points</small>

                        <ol class="mt-2">
                            ${subpoints.map(point => `<li>${point}</li>`).join('')}
                        </ol>

                    </div>

                </div>
            `;
        });

        $('#viewMarks').text(total);
        $('#viewQuestions').html(html);

        $('#viewModal').modal('show');

    });

});
$(document).on('click', '.editBtn', function () {

    let id = $(this).data('id');

    $.get("{{ url('evaluation-form') }}/" + id, function (res) {

        $('#evaluationForm')[0].reset();

        $('#questionsContainer').html('');

        $('#form_id').val(res.id);

        $('[name="name"]').val(res.name);

        let total = 0;

        $.each(res.questions, function (index, item) {

            total += parseInt(item.marks) || 0;

            let subpoints = [];

            if (item.subpoints) {

                if (typeof item.subpoints === 'string') {

                    try {
                        subpoints = JSON.parse(item.subpoints);
                    } catch (e) {
                        subpoints = [];
                    }

                } else {

                    subpoints = item.subpoints;
                }
            }

            let html = `
                <div class="border rounded p-4 mb-3 bg-white question-form">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <h5>Question ${index + 1}</h5>

                        <button
                            type="button"
                            class="btn btn-outline-danger btn-sm"
                            onclick="removeQuestion(this)">
                            Remove
                        </button>

                    </div>

                    <input
                        type="hidden"
                        name="question_id[]"
                        value="${item.id}">

                    <div class="row">

                        <div class="col-md-6">

                            <label>Evaluation Criteria</label>

                            <input
                                type="text"
                                name="question[]"
                                value="${item.question}"
                                class="form-control">

                        </div>

                        <div class="col-md-6">

                            <label>Points</label>

                            <input
                                type="number"
                                name="marks[]"
                                value="${item.marks}"
                                class="form-control marks">

                        </div>

                        <div class="col-md-12 mt-3">

                            <label>Sub Points</label>

                            <textarea
                                name="sub_points[]"
                                class="form-control"
                                rows="4">${subpoints.join('\n')}</textarea>

                        </div>

                    </div>

                </div>
            `;

            $('#questionsContainer').append(html);

        });

        $('#total_points').val(total);

        $('#modalTitle').text('Edit Evaluation Form');

        $('#evaluationFormModal').modal('show');

    });

});
</script>