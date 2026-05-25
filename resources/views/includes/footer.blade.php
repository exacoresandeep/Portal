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
   
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
$(document).ready(function () {

    $('.menu-link').click(function () {

        $('.menu-link').removeClass('active');

        $(this).addClass('active');

        let pageUrl = $(this).data('page');

        $('#main-content').load(pageUrl);

    });

});
</script>
    <!--end::Script-->
  </body>
  <!--end::Body-->
</html>
