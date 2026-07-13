 <footer class="app-footer">
        <!--begin::To the end-->
        <div class="float-end d-none d-sm-inline">2026</div>
        <!--end::To the end-->
        <!--begin::Copyright-->
        <strong>
          Developed by
          <a href="https://exacoreitsolutions.com" class="text-decoration-none">exacoreitsolutions.com</a>.
        </strong>
        <!--end::Copyright-->
      </footer>
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="./js/adminlte.js"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <!-- jQuery -->
      <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

      <!-- DataTables CSS -->
      <link rel="stylesheet"
            href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

      <!-- DataTables JS -->
      <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
    function setCookie(name, value, days) {

        let expires = "";

        if (days) {
            let date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }

        document.cookie = name + "=" + encodeURIComponent(value) + expires + "; path=/";
    }
    function getCookie(name) {

        let nameEQ = name + "=";
        let ca = document.cookie.split(';');

        for (let i = 0; i < ca.length; i++) {

            let c = ca[i].trim();

            if (c.indexOf(nameEQ) == 0) {
                return decodeURIComponent(c.substring(nameEQ.length));
            }
        }

        return null;
    }
$('#pro_employeeEditModal').find('form').each(function () {
    this.reset();
});
function loadPage(pageUrl) {
    if (!pageUrl) return;
    setCookie('activeMenu', pageUrl, 7);
    $('#main-content').load(pageUrl);
}
$(document).ready(function () {
    // Restore last page
    let activeMenu = getCookie('activeMenu');
    if (activeMenu) {
        loadPage(activeMenu);
    } else {
        let firstMenu = $('.menu-link').first();
        if (firstMenu.length) {
            loadPage(firstMenu.data('page'));
        }
    }
    // Parent Menu Click
    $(document).on(
        'click',
        '.nav-item.has-treeview > .nav-link',
        function (e) {

            e.preventDefault();

            let parent = $(this).parent();

            let isOpen = parent.hasClass('menu-open');

            // Close all menus
            $('.nav-item.has-treeview')
                .removeClass('menu-open');

            $('.nav-item.has-treeview > .nav-link')
                .removeClass('active');

            // Open clicked menu only
            if (!isOpen) {

                parent.addClass('menu-open');

                $(this).addClass('active');
            }
        }
    );

    // Sub Menu Click
    $(document).on(
        'click',
        '.menu-link',
        function (e) {

            e.preventDefault();

            let pageUrl = $(this).data('page');

            // Remove submenu active only
            $('.menu-link').removeClass('active');

            $(this).addClass('active');

            // Keep parent open
            let parent = $(this)
                .closest('.nav-item.has-treeview');

            if (parent.length) {

                $('.nav-item.has-treeview')
                    .not(parent)
                    .removeClass('menu-open');

                $('.nav-item.has-treeview > .nav-link')
                    .not(parent.children('.nav-link'))
                    .removeClass('active');

                parent.addClass('menu-open');

                parent.children('.nav-link')
                    .addClass('active');
            }

            loadPage(pageUrl);

        }
    );
});

function viewProEmployee(id)
{
    $.ajax({
        url: '/employee/details/' + id,
        type: 'GET',

        success: function(response) {

            $('#pro_employee_name').text(response.name);
            $('#pro_employee_profile_image').attr('src', response.photo_url);
            $('#pro_employee_designation').text(response.designation?.name ?? '-');
            $('#pro_employee_code').text(response.emp_id ?? '-');
            $('#pro_profile_email').text(response.email ?? '-');
            $('#pro_profile_phone').text(response.contact_no ?? '-');
            $('#pro_profile_gender').text(response.gender ?? '-');
            $('#pro_profile_blood_group').text(response.blood_group ?? '-');
            $('#pro_profile_nationality').text(response.nationality ?? '-');

            $('#pro_profile_dob').text(response.dob ?? '-');
            $('#pro_profile_emergency_phone').text(response.alt_contact_no ?? '-');
            $('#pro_profile_marital_status').text(response.marital_status ?? '-');
            $('#pro_profile_parent_name').text(response.parent_name ?? '-');
            $('#pro_profile_address').text(response.address ?? '-');
            // Official Information

            $('#view_pro_emp_id').text(response.emp_id ?? '-');
            $('#view_pro_email').text(response.email ?? '-');
            $('#view_pro_department').text(response.department?.name ?? '-');
            $('#view_pro_designation').text(response.designation?.name ?? '-');
            $('#view_pro_reporting_manager').text(response.reporting_manager?.name ?? '-');
            $('#view_pro_joining_date').text(response.joining_date ?? '-');
            $('#view_pro_job_type').text(response.job_type ?? '-');
            $('#view_pro_job_location').text(response.job_location ?? '-');
            $('#view_pro_work_location').text(response.work_location ?? '-');
            $('#view_pro_status').text(response.status == 1 ? 'Active' : 'Inactive');

            // Identity Information

            $('#pro_identity_aadhar').text(
                response.aadhar_no ?? '-'
            );

            $('#pro_identity_pan').text(
                response.pan_no ?? '-'
            );

            $('#pro_identity_passport').text(
                response.passport_no ?? '-'
            );

            $('#pro_identity_uan').text(
                response.uan ?? '-'
            );

            $('#pro_identity_insurance').text(
                response.insurance_no ?? '-'
            );
            $('#pro_employee_status').text(
                response.status == 1 ? 'Active' : 'Inactive'
            );
            $('#pro_bank_account_no').text(response.account_no ?? '-');

            $('#pro_bank_name').text(response.bank_name ?? '-');

            $('#pro_bank_ifsc').text(response.ifsc ?? '-');

            $('#pro_bank_branch').text(response.branch ?? '-');
            $('#pro_educationTableBody').html('');

            if (response.educations && response.educations.length > 0) {

                $.each(response.educations, function(index, education){

                    $('#pro_educationTableBody').append(`
                        <tr>

                            <td>${education.qualification ?? '-'}</td>

                            <td>${education.university_board ?? '-'}</td>

                            <td>${education.passing_year ?? '-'}</td>

                            <td>${education.percentage ?? '-'}%</td>

                            <td>
                                
            
                            ${education.attachment ? `<a href="javascript:void(0)"
                            onclick="viewProAttachment('${education.attachment}')"
                            class="btn btn-sm btn-primary">

                                <i class="bi bi-eye-fill"></i>

                                </a>
                                <a href="${education.attachment}" download class="btn btn-sm btn-success">
                                    <i class="bi bi-download"></i>
                                </a>` : '-'}
                            </td>

                        </tr>
                    `);

                });

            }
            else{

                $('#pro_educationTableBody').html(`
                    <tr>
                        <td colspan="5" class="text-center">
                            No education details found.
                        </td>
                    </tr>
                `);

            }
            $('#pro_experienceTableBody').html('');

            if (response.experiences && response.experiences.length > 0) {

                $.each(response.experiences, function(index, experience) {

                    let attachment = '-';

                    if (experience.attachment) {
                        attachment = `
                            <a href="javascript:void(0)"
                                onclick="viewProAttachment('${experience.attachment}')"
                                class="btn btn-sm btn-primary"
                                title="View">

                                    <i class="bi bi-eye-fill"></i>

                                </a>

                            <a href="${experience.attachment}" download title="Download"  class="btn btn-sm btn-success">
                                <i class="bi bi-download"></i>
                            </a>
                        `;
                    }

                    $('#pro_experienceTableBody').append(`
                        <tr>

                            <td>${experience.company_name ?? '-'}</td>

                            <td>${experience.job_role ?? '-'}</td>

                            <td>${experience.year_of_experience ?? '-'} Year(s)</td>

                            <td>${attachment}</td>

                        </tr>
                    `);

                });

            } else {

                $('#pro_experienceTableBody').html(`
                    <tr>
                        <td colspan="4" class="text-center">
                            No experience details found.
                        </td>
                    </tr>
                `);

            }
            $('#pro_doc_aadhar').html(
                documentProCard('Aadhaar Card',response.adhar_card)
            );

            $('#pro_doc_pan').html(
                documentProCard('PAN Card',response.pan_card)
            );

            $('#pro_doc_passport').html(
                documentProCard('Passport',response.passport)
            );

            $('#pro_doc_resume').html(
                documentProCard('Resume',response.resume)
            );

            $('#pro_doc_passbook').html(
                documentProCard('Passbook',response.passbook)
            );

            $('#pro_doc_insurance').html(
                documentProCard('Insurance Card',response.insurance)
            );
            $('#pro_employeeProfileModal').modal('show');
        },
            error: function(xhr, status, error) {

            console.error(error);

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Unable to fetch employee details. Please try again.'
            });

            // Optional: clear modal fields
            $('#pro_employee_name').text('');
            $('#pro_employee_email').text('');
        }
    });
}

function documentProCard(title,file){

    if(!file){

        return `
            <label class="fw-semibold">${title}</label>

            <div class="border rounded p-3 text-muted">

                No document uploaded

            </div>
        `;
    }

    let fileName=file.split('/').pop();

    return `
    <label class="fw-semibold">${title}</label>
    <div class="border rounded p-3 d-flex justify-content-between align-items-center">
        <div>
           <i class="bi bi-file-earmark-pdf-fill text-danger fs-4 me-2"></i>
            ${fileName}
        </div>
        <div>
            <a href="${file}" target="_blank" class="btn btn-sm btn-primary">
                <i class="bi bi-eye-fill"></i>
            </a>
            <a href="${file}" download class="btn btn-sm btn-success">
                <i class="bi bi-download"></i>
            </a>
        </div>
    </div>
    `;
}

function viewProAttachment(file)
{
    if (!file) return;

    let extension = file.split('.').pop().toLowerCase();

    $('#pro_attachmentImage').addClass('d-none');
    $('#pro_attachmentPdf').addClass('d-none');

    $('#pro_attachmentDownload').attr('href', file);

    if (['jpg','jpeg','png','gif','webp'].includes(extension)) {

        $('#pro_attachmentImage')
            .attr('src', file)
            .removeClass('d-none');

    }
    else if (extension === 'pdf') {

        $('#pro_attachmentPdf')
            .attr('src', file)
            .removeClass('d-none');

    }
    else {

        window.open(file,'_blank');
        return;

    }

    $('#pro_attachmentViewerModal').modal('show');
}

function editProEmployee(id)
{

    $.ajax({
        

        url:'/employee/edit/'+id,

        type:'GET',

        beforeSend:function(){

            Swal.fire({
                title:'Loading...',
                text:'Fetching employee details',
                allowOutsideClick:false,
                didOpen:()=>{
                    Swal.showLoading();
                }
            });

        },

        success:function(emp){

            Swal.close();

            // Hidden ID
            $('#pro_edit_employee_id').val(emp.id);
            $('#reset_employee_id').val(emp.id);
            $('#pro_profile_id').val(emp.id);
            $('#pro_official_id').val(emp.id);

            // Header
            $('#pro_edit_employee_name').text(emp.name);

            if(emp.photo){
                $('#pro_edit_profile_image').attr('src',emp.photo);
            }

            // Profile

            $('#pro_edit_name').val(emp.name);
            $('#pro_edit_personal_email').val(emp.personal_email);
            $('#pro_edit_dob').val(emp.dob);
            $('#pro_edit_emergency_phone').val(emp.alt_contact_no);
            $('#pro_edit_marital_status').val(emp.marital_status);
            $('#pro_edit_guardian_name').val(emp.parent_name);
            $('#pro_edit_address').val(emp.address);
            $('#pro_edit_emp_id').val(emp.emp_id);

            $('#pro_edit_phone').val(emp.contact_no);
            $('#pro_edit_gender').val(emp.gender);
            $('#pro_edit_blood_group').val(emp.blood_group);
            $('#pro_edit_nationality').val(emp.nationality);

            // Official Information
            $('#pro_view_emp_id').text(emp.emp_id ?? '-');
            $('#pro_view_email').text(emp.email ?? '-');
            $('#pro_view_department').text(emp.department?.name ?? '-');
            $('#pro_view_designation').text(emp.designation?.name ?? '-');
            $('#pro_view_reporting_manager').text(emp.reporting_manager?.name ?? '-');
            $('#pro_view_joining_date').text(emp.joining_date ?? '-');
            $('#pro_view_job_type').text(emp.job_type ?? '-');
            $('#pro_view_job_location').text(emp.job_location ?? '-');
            $('#pro_view_work_location').text(emp.work_location ?? '-');
            $('#pro_view_status').text(emp.status == 1 ? 'Active' : 'Inactive');

            // Banking

            $('#pro_edit_bank').val(emp.bank_name);
            $('#pro_edit_account').val(emp.account_no);

            // Open first tab

            $('#pro_employeeEditModal').modal('show');

            $('#pro_employeeEditModal .nav-link:first').tab('show');

        },

        error:function(xhr){

            Swal.fire({
                icon:'error',
                title:'Error',
                text:xhr.responseJSON?.message ?? 'Unable to load employee.'
            });

        }

    });

}

function togglePassword(id, button) {

    let input = $('#' + id);

    if (input.attr('type') === 'password') {

        input.attr('type', 'text');
        $(button).find('i').removeClass('bi-eye').addClass('bi-eye-slash');

    } else {

        input.attr('type', 'password');
        $(button).find('i').removeClass('bi-eye-slash').addClass('bi-eye');

    }

}

$('#changePasswordBtn').click(function () {

    let employee_id = $('#reset_employee_id').val();
    let password = $('#new_password').val();
    let confirmPassword = $('#confirm_password').val();

    if (password == '') {

        Swal.fire({
            icon: 'warning',
            title: 'Warning',
            text: 'Please enter new password.'
        });

        return;
    }

    if (password != confirmPassword) {

        Swal.fire({
            icon: 'error',
            title: 'Password Mismatch',
            text: 'Both passwords must be the same.'
        });

        return;
    }

    Swal.fire({

        title: 'Are you sure?',
        text: 'Do you want to change this employee password?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Change Password',
        cancelButtonText: 'Cancel'

    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: '/employee/change-password/' + employee_id,
                type: 'POST',

                data: {

                    password: password,
                    _token: $('meta[name="csrf-token"]').attr('content')

                },

                success: function (response) {

                    Swal.fire({

                        icon: 'success',
                        title: 'Success',
                        text: response.message

                    });

                    $('#new_password').val('');
                    $('#confirm_password').val('');

                },

                error: function () {

                    Swal.fire({

                        icon: 'error',
                        title: 'Error',
                        text: 'Unable to change password.'

                    });

                }

            });

        }

    });

});


var working = "00:00:00";
var breaking = "00:00:00";
var lastDirection = "";
var timer = null;

$(document).ready(function () {

    loadAttendance();

    setInterval(function () {
        loadAttendance();
    }, 60000);

});

function loadAttendance() {

    $.ajax({
        url: "{{ route('dashboard.attendance') }}",
        type: "GET",

        success: function(res){

            working = res.workingHours;
            breaking = res.breakHours;
            lastDirection = res.lastDirection;

            if(res.checkIn == "Not Checked In"){

                $("#checkInTime")
                    .removeClass("text-success")
                    .addClass("text-danger")
                    .html('<i class="bi bi-x-circle-fill"></i> Not Checked');

            }else{

                $("#checkInTime")
                    .removeClass("text-danger")
                    .addClass("text-success")
                    .html('<i class="bi bi-check-circle-fill"></i> ' + res.checkIn);

            }

            $("#workingHours").text(working);
            $("#breakHours").text(breaking);

            startTimer();
        }
    });

}

function tick(time){

    let p = time.split(':');

    let sec =
        parseInt(p[0]) * 3600 +
        parseInt(p[1]) * 60 +
        parseInt(p[2]);

    sec++;

    let h = String(Math.floor(sec / 3600)).padStart(2,'0');
    let m = String(Math.floor((sec % 3600) / 60)).padStart(2,'0');
    let s = String(sec % 60).padStart(2,'0');

    return h + ":" + m + ":" + s;
}

function startTimer(){

    if(timer){
        clearInterval(timer);
    }

    timer = setInterval(function(){

        if(lastDirection === "in"){

            working = tick(working);
            $("#workingHours").text(working);

        }else if(lastDirection === "out"){

            breaking = tick(breaking);
            $("#breakHours").text(breaking);

        }

    },1000);

}

</script>
    <!--end::Script-->
  </body>
  <!--end::Body-->
</html>
