{{-- @if(Auth::check() && Auth::user()->role_id == 1) --}}
 <!--begin::Sidebar-->
      <aside class="app-sidebar bg-body">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="{{ route('dashboard') }}" class="brand-link" >
            <!--begin::Brand Image-->
            <img
              src="{{ asset('assets/images/logo.svg') }}"
              alt="Exacore EPortal Logo"
              class="brand-image opacity-75" style="width: 180px; height: auto;"
            />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light" ></span>
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="navigation"
              aria-label="Main navigation"
              data-accordion="false"
              id="navigation"
            >
              {{-- <li class="nav-item menu-open">
                <a href="{{ route('dashboard.content') }}" class="nav-link active">
                  <i class="nav-icon bi bi-speedometer"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
                
              </li>
              <li class="nav-item">
                <a href="{{ route('samplepage') }}" class="nav-link">
                  <i class="nav-icon bi bi-palette"></i>
                  <p>Sample page</p>
                </a>
              </li> --}}
              <li class="nav-item">
                <a href="javascript:void(0)"
                  class="nav-link menu-link active"
                  data-page="{{ route('dashboard.content') }}">

                    <i class="nav-icon bi bi-speedometer"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="javascript:void(0)"
                  class="nav-link menu-link"
                  data-page="{{ route('samplepage') }}">

                    <i class="nav-icon bi bi-palette"></i>
                    <p>Sample page</p>
                </a>
            </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-box-seam-fill"></i>
                  <p>
                    Widgets
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./widgets/small-box.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Small Box</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./widgets/info-box.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>info Box</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./widgets/cards.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Cards</p>
                    </a>
                  </li>
                </ul>
              </li>
              
            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>
{{-- @endif --}}
