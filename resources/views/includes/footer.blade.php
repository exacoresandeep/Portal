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
$(document).ready(function () {

    function loadPage(pageUrl) {

        if (!pageUrl) return;

        localStorage.setItem('activeMenu', pageUrl);

        $('#main-content').load(pageUrl);
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

    // Restore last page
    let activeMenu = localStorage.getItem('activeMenu');

    if (activeMenu) {

        loadPage(activeMenu);

    } else {

        let firstMenu = $('.menu-link').first();

        if (firstMenu.length) {

            loadPage(firstMenu.data('page'));
        }
    }

});
</script>
    <!--end::Script-->
  </body>
  <!--end::Body-->
</html>
