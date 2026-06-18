<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- OverlayScrollbars -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css">
    <!-- ApexCharts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css">
    @stack('styles')
</head>


  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      <nav class="app-header navbar navbar-expand bg-body">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Start Navbar Links-->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
              </a>
            </li>
            <li class="nav-item d-none d-md-block">
              <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
            </li>
           
          </ul>
          <!--end::Start Navbar Links-->

          <!--begin::End Navbar Links-->
          <ul class="navbar-nav ms-auto">
            

            <!--begin::Messages Dropdown Menu-->
            <li class="nav-item dropdown">
              <a class="nav-link" data-bs-toggle="dropdown" href="#">
                <i class="bi bi-backpack4-fill"></i>
                <span class="navbar-badge badge text-bg-danger">3</span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <a href="#" class="dropdown-item">
                  <!--begin::Message-->
                  <div class="d-flex">
                    <div class="flex-shrink-0">
                      <img
                        src="./assets/img/user1-128x128.jpg"
                        alt="User Avatar"
                        class="img-size-50 rounded-circle me-3"
                      />
                    </div>
                    <div class="flex-grow-1">
                      <h3 class="dropdown-item-title">
                        Brad Diesel
                        <span class="float-end fs-7 text-danger"
                          ><i class="bi bi-star-fill"></i
                        ></span>
                      </h3>
                      <p class="fs-7">Call me whenever you can...</p>
                      <p class="fs-7 text-secondary">
                        <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                      </p>
                    </div>
                  </div>
                  <!--end::Message-->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <!--begin::Message-->
                  <div class="d-flex">
                    <div class="flex-shrink-0">
                      <img
                        src="./assets/img/user8-128x128.jpg"
                        alt="User Avatar"
                        class="img-size-50 rounded-circle me-3"
                      />
                    </div>
                    <div class="flex-grow-1">
                      <h3 class="dropdown-item-title">
                        John Pierce
                        <span class="float-end fs-7 text-secondary">
                          <i class="bi bi-star-fill"></i>
                        </span>
                      </h3>
                      <p class="fs-7">I got your message bro</p>
                      <p class="fs-7 text-secondary">
                        <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                      </p>
                    </div>
                  </div>
                  <!--end::Message-->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <!--begin::Message-->
                  <div class="d-flex">
                    <div class="flex-shrink-0">
                      <img
                        src="./assets/img/user3-128x128.jpg"
                        alt="User Avatar"
                        class="img-size-50 rounded-circle me-3"
                      />
                    </div>
                    <div class="flex-grow-1">
                      <h3 class="dropdown-item-title">
                        Nora Silvester
                        <span class="float-end fs-7 text-warning">
                          <i class="bi bi-star-fill"></i>
                        </span>
                      </h3>
                      <p class="fs-7">The subject goes here</p>
                      <p class="fs-7 text-secondary">
                        <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                      </p>
                    </div>
                  </div>
                  <!--end::Message-->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
              </div>
            </li>
            <!--end::Messages Dropdown Menu-->

            <!--begin::Notifications Dropdown Menu-->
            <li class="nav-item dropdown">
              <a class="nav-link" data-bs-toggle="dropdown" href="#">
                <i class="bi bi-bell-fill"></i>
                <span class="navbar-badge badge text-bg-warning">15</span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <i class="bi bi-envelope me-2"></i> 4 new messages
                  <span class="float-end text-secondary fs-7">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <i class="bi bi-people-fill me-2"></i> 8 friend requests
                  <span class="float-end text-secondary fs-7">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <i class="bi bi-file-earmark-fill me-2"></i> 3 new reports
                  <span class="float-end text-secondary fs-7">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer"> See All Notifications </a>
              </div>
            </li>
            <!--end::Notifications Dropdown Menu-->

            <!--begin::Fullscreen Toggle-->
            <li class="nav-item">
              <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
              </a>
            </li>
            <!--end::Fullscreen Toggle-->
            
            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
               <img
                src="{{ session('user_photo') ? asset('storage/employees/photos/' . session('user_photo')) : asset('assets/img/user.png') }}"
                class="user-image rounded-circle shadow"
                alt="User Image"
            />
                <span class="d-none d-md-inline">{{ session('user_name') }}</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <!--begin::User Image-->
                <li class="user-header">
                  <img
                    src="{{ session('user_photo') ? asset('storage/employees/photos/' . session('user_photo')) : asset('assets/img/user.png') }}"
                    class="rounded-circle shadow"
                    alt="User Image"
                  />
                  <p>
                    Name: {{ session('user_name') }} <br>
                    Designation:  {{ session('designation') }}
                    {{-- <small>Member since Nov. 2023</small> --}}
                  </p>
                </li>
                <!--end::User Image-->
                
                <!--begin::Menu Footer-->
                <li class="user-footer d-flex align-items-center w-100">

                  <a href="#" class="btn btn-outline-secondary"  data-bs-toggle="modal"
   data-bs-target="#profileModal">
                      Profile
                  </a>

                  <form method="POST" action="{{ route('logout') }}" class="ms-auto">
                      @csrf

                      <button type="submit" class="btn btn-outline-danger">
                          Sign out
                      </button>
                  </form>

              </li>
                <!--end::Menu Footer-->
              </ul>
            </li>
            <!--end::User Menu Dropdown-->
          </ul>
          <!--end::End Navbar Links-->
        </div>
        <!--end::Container-->
      </nav>
      <!--end::Header-->


  <!-- Modal for Profile -->
  <!-- Profile Modal -->
  <div class="modal fade"
      id="profileModal"
      tabindex="-1"
      aria-hidden="true">

      <div class="modal-dialog modal-xl modal-dialog-centered">

          <div class="modal-content border-0 rounded-4">

              <!-- Header -->
              <div class="modal-header border-0">

                  <div class="d-flex align-items-center gap-3">

                      <img
                        src="{{ session('user_photo') ? asset('storage/employees/photos/' . session('user_photo')) : asset('assets/img/user.png') }}"
                          class="rounded-circle"
                          width="70"
                          height="70">
                      <div>

                          <h5 class="fw-bold mb-1">
                              John Smsith
                          </h5>

                          <div class="text-muted small">
                              UI-UX Designer
                          </div>

                          <div class="text-muted small">
                              E2406
                          </div>

                      </div>

                  </div>

                  <button type="button"
                          class="btn-close"
                          data-bs-dismiss="modal"></button>

              </div>

              <div class="modal-body">

                  <hr>

                  <!-- Tabs -->
                  <ul class="nav nav-pills mb-4 gap-2"
                      id="profileTabs"
                      role="tablist">

                      <li class="nav-item">
                          <button class="nav-link active"
                                  data-bs-toggle="pill"
                                  data-bs-target="#profileInfo">

                              Profile Information

                          </button>
                      </li>

                      <li class="nav-item">
                          <button class="nav-link"
                                  data-bs-toggle="pill"
                                  data-bs-target="#officialInfo">

                              Official Information

                          </button>
                      </li>

                      <li class="nav-item">
                          <button class="nav-link"
                                  data-bs-toggle="pill"
                                  data-bs-target="#identityInfo">

                              Identity Information

                          </button>
                      </li>

                      <li class="nav-item">
                          <button class="nav-link"
                                  data-bs-toggle="pill"
                                  data-bs-target="#educationInfo">

                              Educational Information

                          </button>
                      </li>

                      <li class="nav-item">
                          <button class="nav-link"
                                  data-bs-toggle="pill"
                                  data-bs-target="#bankInfo">

                              Banking Details

                          </button>
                      </li>

                      <li class="nav-item">
                          <button class="nav-link"
                                  data-bs-toggle="pill"
                                  data-bs-target="#documentInfo">

                              Document Management

                          </button>
                      </li>

                  </ul>

                  <!-- Tab Content -->
                  <div class="tab-content">

                      <!-- Profile Information -->
                      <div class="tab-pane fade show active"
                          id="profileInfo">

                          <h6 class="fw-semibold mb-4">
                              Profile Information
                          </h6>

                          <div class="row gy-4">

                              <div class="col-md-6">

                                  <div class="mb-3">
                                      <small class="text-muted d-block">
                                          Personal Email
                                      </small>

                                      <div class="fw-medium">
                                          john.smith@gmail.com
                                      </div>
                                  </div>

                                  <div class="mb-3">
                                      <small class="text-muted d-block">
                                          Phone
                                      </small>

                                      <div class="fw-medium">
                                          9087654321
                                      </div>
                                  </div>

                                  <div class="mb-3">
                                      <small class="text-muted d-block">
                                          Gender
                                      </small>

                                      <div class="fw-medium">
                                          Male
                                      </div>
                                  </div>

                                  <div class="mb-3">
                                      <small class="text-muted d-block">
                                          Blood Group
                                      </small>

                                      <div class="fw-medium">
                                          AB+ve
                                      </div>
                                  </div>

                                  <div class="mb-3">
                                      <small class="text-muted d-block">
                                          Nationality
                                      </small>

                                      <div class="fw-medium">
                                          Indian
                                      </div>
                                  </div>

                              </div>

                              <div class="col-md-6">

                                  <div class="mb-3">
                                      <small class="text-muted d-block">
                                          Date of Birth
                                      </small>

                                      <div class="fw-medium">
                                          18-07-1999
                                      </div>
                                  </div>

                                  <div class="mb-3">
                                      <small class="text-muted d-block">
                                          Emergency Phone
                                      </small>

                                      <div class="fw-medium">
                                          8097654432
                                      </div>
                                  </div>

                                  <div class="mb-3">
                                      <small class="text-muted d-block">
                                          Marital Status
                                      </small>

                                      <div class="fw-medium">
                                          Unmarried
                                      </div>
                                  </div>

                                  <div class="mb-3">
                                      <small class="text-muted d-block">
                                          Father/Mother Name
                                      </small>

                                      <div class="fw-medium">
                                          Abhin Das
                                      </div>
                                  </div>

                                  <div class="mb-3">
                                      <small class="text-muted d-block">
                                          Address
                                      </small>

                                      <div class="fw-medium">
                                          Flat No. 3B, Galaxy Apartments,
                                          MG Road, Thrissur, Kerala - 680001
                                      </div>
                                  </div>

                              </div>

                          </div>

                      </div>

                      <!-- Official Information -->
                      <div class="tab-pane fade"
                          id="officialInfo">

                          <h6 class="fw-semibold mb-4">
                              Official Information
                          </h6>

                          <div class="row">

                              <div class="col-md-6">

                                  <div class="mb-3">
                                      <small class="text-muted d-block">
                                          Employee ID
                                      </small>

                                      <div class="fw-medium">
                                          E2406
                                      </div>
                                  </div>

                                  <div class="mb-3">
                                      <small class="text-muted d-block">
                                          Department
                                      </small>

                                      <div class="fw-medium">
                                          Digital
                                      </div>
                                  </div>

                              </div>

                              <div class="col-md-6">

                                  <div class="mb-3">
                                      <small class="text-muted d-block">
                                          Designation
                                      </small>

                                      <div class="fw-medium">
                                          UI-UX Designer
                                      </div>
                                  </div>

                                  <div class="mb-3">
                                      <small class="text-muted d-block">
                                          Joining Date
                                      </small>

                                      <div class="fw-medium">
                                          17-03-2025
                                      </div>
                                  </div>

                              </div>

                          </div>

                      </div>

                      <!-- Identity -->
                      <div class="tab-pane fade"
                          id="identityInfo">

                          <h6 class="fw-semibold mb-4">
                              Identity Information
                          </h6>

                          <p>PAN, Aadhaar, Passport details here.</p>

                      </div>

                      <!-- Education -->
                      <div class="tab-pane fade"
                          id="educationInfo">

                          <h6 class="fw-semibold mb-4">
                              Educational Information
                          </h6>

                          <p>Education details here.</p>

                      </div>

                      <!-- Bank -->
                      <div class="tab-pane fade"
                          id="bankInfo">

                          <h6 class="fw-semibold mb-4">
                              Banking Details
                          </h6>

                          <p>Bank details here.</p>

                      </div>

                      <!-- Documents -->
                      <div class="tab-pane fade"
                          id="documentInfo">

                          <h6 class="fw-semibold mb-4">
                              Document Management
                          </h6>

                          <p>Uploaded documents here.</p>

                      </div>

                  </div>

              </div>

          </div>

      </div>

  </div>