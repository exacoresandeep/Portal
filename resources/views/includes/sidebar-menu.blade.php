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
              id="navigation" style="width: 255px;"

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
                <a href="javascript:void(0)" class="nav-link">
                  <i class="nav-icon bi bi-person-plus-fill"></i>
                  <p>
                    Employee Management
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="javascript:void(0)"
                  data-page="{{ route('employees.index') }}" class="nav-link menu-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Employee Directory</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="javascript:void(0)"
                  data-page="{{ route('employeedirectory.index') }}" class="nav-link menu-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Onboarding Employee</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="javascript:void(0)"
                  data-page="{{ route('offboard.index') }}" class="nav-link menu-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Offboarding Management</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link">
                  <i class="nav-icon bi bi-laptop"></i>
                  <p>
                    Asset Management
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="javascript:void(0)"
                  data-page="{{ route('assets.requests') }}" class="nav-link menu-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Asset Requests</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="javascript:void(0)"
                  data-page="{{ route('assets.assigned') }}" class="nav-link menu-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Assigned Assets</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link">
                  <i class="bi bi-calendar-week-fill"></i>
                  <p>
                    Attendance Reports
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="javascript:void(0)"
                  data-page="{{ route('attendance.capture') }}" class="nav-link menu-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Attendance Capture</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="javascript:void(0)"
                      data-page="{{ route('attendance.schedule') }}" class="nav-link menu-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Work Schedule Config.</p>
                    </a>
                  </li>
                   <li class="nav-item">
                    <a href="javascript:void(0)"
                      data-page="{{ route('attendance.tracking') }}" class="nav-link menu-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Attendance Tracking</p>
                    </a>
                  </li>
                   <li class="nav-item">
                    <a href="javascript:void(0)"
                  data-page="{{ route('attendance.regularization') }}" class="nav-link menu-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Regularization Request</p>
                    </a>
                  </li>
                   <li class="nav-item">
                    <a href="javascript:void(0)"
                  data-page="{{ route('attendance.summary') }}" class="nav-link menu-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Attendance Summary</p>
                    </a>
                  </li>
                   <li class="nav-item">
                    <a href="javascript:void(0)"
                  data-page="{{ route('attendance.reports') }}" class="nav-link menu-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Reports</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link">
                  <i class="nav-icon bi bi-person-plus-fill"></i>
                  <p>
                    Leave Management
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="javascript:void(0)"
                  data-page="{{ route('leave.index') }}" class="nav-link menu-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Leave Requests</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="javascript:void(0)"
                  data-page="{{ route('wfh.index') }}" class="nav-link menu-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>WFH Requests</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="javascript:void(0)"
                  data-page="{{ route('leavecount.index') }}" class="nav-link menu-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Leave Counts</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item menu-open">
                <a href="javascript:void(0)"
                  data-page="{{ route('expense.index') }}" class="nav-link menu-link">
                  <i class="nav-icon bi bi-speedometer"></i>
                  <p>
                    Expense Requests
                  </p>
                </a>
                
              </li>
              <li class="nav-item menu-open">
                <a href="javascript:void(0)"
                  data-page="{{ route('project.index') }}" class="nav-link menu-link">
                  <i class="nav-icon bi bi-kanban-fill"></i>
                  <p>
                    Project Management
                  </p>
                </a>
                
              </li>
              <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link">
                  <i class="nav-icon bi bi-speedometer2"></i>
                  <p>
                    Performance Tracking
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="javascript:void(0)"
                  data-page="{{ route('evaluation.forms') }}" class="nav-link menu-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Evaluation Form</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="javascript:void(0)"
                  data-page="{{ route('evaluation.scheduling') }}" class="nav-link menu-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Evaluation Scheduling</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="javascript:void(0)"
                  data-page="{{ route('evaluation.report') }}" class="nav-link menu-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Evaluation Report</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="javascript:void(0)"
                  data-page="{{ route('evaluation.pip') }}" class="nav-link menu-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>PIP</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link">
                  <i class="nav-icon bi bi-journal-bookmark-fill"></i>
                  <p>
                    Learning & Developing
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="javascript:void(0)"
                  data-page="{{ route('training.phase.index') }}" class="nav-link menu-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Training Phases</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="javascript:void(0)"
                  data-page="{{ route('training.assign.index') }}" class="nav-link menu-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Training Management</p>
                    </a>
                  </li>
                  {{-- <li class="nav-item">
                    <a href="javascript:void(0)"
                  data-page="{{ route('training.report.index') }}" class="nav-link menu-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Report</p>
                    </a>
                  </li> --}}
                  
                </ul>
              </li>
            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>
{{-- @endif --}}
