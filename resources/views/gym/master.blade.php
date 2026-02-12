<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="Gym Management System">
    <meta name="author" content="FitGym">

    <title>{{ $title ?? 'Dashboard' }} - FitGym Admin</title>

    <!-- Fonts -->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,
600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">


    <!-- Custom Gym Styles -->
    <style>
    .bg-gradient-success-custom {
        background: linear-gradient(87deg, #2dce89 0, #2dcecc 100%) !important;
    }

    .text-success-custom {
        color: #2dce89 !important;
    }

    .btn-success-custom {
        background-color: #2dce89;
        border-color: #2dce89;
    }

    .sidebar-dark .nav-item .nav-link {
        color: rgba(255, 255, 255, 0.8);
    }

    .sidebar-dark .nav-item .nav-link:hover {
        color: #fff;
    }

    .sidebar-dark .nav-item .nav-link.active {
        color: #fff;
        background-color: #2dce89;
    }
    </style>

</head>

<body id="page-top">

    <div id="wrapper">


        {{-- ================= SIDEBAR ================= --}}

        <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

            {{-- Brand --}}
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('gym') }}">

                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-dumbbell"></i>
                </div>

                <div class="sidebar-brand-text mx-3">
                    FitGym <sup>Admin</sup>
                </div>

            </a>


            <hr class="sidebar-divider my-0">


            {{-- Dashboard --}}
            <li class="nav-item {{ request()->is('gym') ? 'active' : '' }}">

                <a class="nav-link" href="{{ url('gym') }}">

                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>

                </a>

            </li>


            <hr class="sidebar-divider">


            <div class="sidebar-heading">
                Member Management
            </div>


            {{-- Members --}}
            <li class="nav-item {{ request()->is('gym/members*') ? 'active' : '' }}">

                <a class="nav-link" href="{{ url('gym/members') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Members</span>
                </a>

            </li>


            {{-- Plans --}}
            <li class="nav-item {{ request()->is('gym/membership_plans*') ? 'active' : '' }}">

                <a class="nav-link" href="{{ url('gym/membership_plans') }}">
                    <i class="fas fa-fw fa-tags"></i>
                    <span>Membership Plans</span>
                </a>

            </li>


            {{-- Subscriptions --}}
            <li class="nav-item {{ request()->is('gym/subscriptions*') ? 'active' : '' }}">

                <a class="nav-link" href="{{ url('gym/subscriptions') }}">
                    <i class="fas fa-fw fa-credit-card"></i>
                    <span>Subscriptions</span>
                </a>

            </li>


            <hr class="sidebar-divider">


            <div class="sidebar-heading">
                Operations
            </div>


            {{-- Attendance --}}
            <li class="nav-item {{ request()->is('gym/attendance*') ? 'active' : '' }}">

                <a class="nav-link" href="{{ url('gym/attendance') }}">
                    <i class="fas fa-fw fa-calendar-check"></i>
                    <span>Attendance</span>
                </a>

            </li>


            {{-- Reports --}}
            <li class="nav-item">

                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReports">

                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Reports</span>

                </a>


                <div id="collapseReports" class="collapse {{ request()->is('gym/*report*') ? 'show' : '' }}">

                    <div class="bg-white py-2 collapse-inner rounded">

                        <h6 class="collapse-header">Financial Reports</h6>

                        <a class="collapse-item {{ request()->is('gym/income_report') ? 'active' : '' }}"
                            href="{{ url('gym/income_report') }}">

                            Uang Masuk
                        </a>

                        <a class="collapse-item {{ request()->is('gym/expense_report') ? 'active' : '' }}"
                            href="{{ url('gym/expense_report') }}">

                            Uang Keluar
                        </a>


                        <div class="collapse-divider"></div>

                        <h6 class="collapse-header">Member Reports</h6>

                        <a class="collapse-item {{ request()->is('gym/member_report') ? 'active' : '' }}"
                            href="{{ url('gym/member_report') }}">

                            Laporan Member
                        </a>

                    </div>
                </div>

            </li>


            <hr class="sidebar-divider d-none d-md-block">


            {{-- Toggler --}}
            <div class="text-center d-none d-md-inline">

                <button class="rounded-circle border-0" id="sidebarToggle"></button>

            </div>

        </ul>


        {{-- ================= CONTENT ================= --}}

        <div id="content-wrapper" class="d-flex flex-column">


            <div id="content">


                {{-- ================= TOPBAR ================= --}}

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 shadow">


                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">

                        <i class="fa fa-bars"></i>

                    </button>


                    {{-- Search --}}
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3">

                        <div class="input-group">

                            <input type="text" class="form-control bg-light border-0 small"
                                placeholder="Search for members...">

                            <div class="input-group-append">

                                <button class="btn btn-success">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>

                            </div>

                        </div>

                    </form>


                    {{-- User --}}
                    <ul class="navbar-nav ml-auto">


                        <div class="topbar-divider d-none d-sm-block"></div>


                        <li class="nav-item dropdown no-arrow">


                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">

                                <span class="mr-2 text-gray-600 small">

                                    {{ auth()->user()->name ?? 'Admin' }}

                                </span>

                                <img class="img-profile rounded-circle"
                                    src="{{ asset('assets/img/profile/'.(auth()->user()->image ?? 'default.jpg')) }}">

                            </a>


                            <div class="dropdown-menu dropdown-menu-right shadow">


                                <a class="dropdown-item" href="{{ url('gym/profile') }}">

                                    Profile
                                </a>


                                <a class="dropdown-item" href="{{ url('gym/change_password') }}">

                                    Change Password
                                </a>


                                <div class="dropdown-divider"></div>


                                <a class="dropdown-item" href="{{ url('logout') }}">

                                    Logout
                                </a>

                            </div>

                        </li>

                    </ul>

                </nav>


                {{-- ================= PAGE CONTENT ================= --}}

                <div class="container-fluid">


                    {{-- Heading --}}
                    <h1 class="h3 mb-4 text-gray-800">
                        {{ $title ?? '' }}
                    </h1>


                    {{-- Flash --}}
                    @if(session('success'))

                    <div class="alert alert-success alert-dismissible fade show">

                        {{ session('success') }}

                        <button class="close" data-dismiss="alert">&times;</button>

                    </div>

                    @endif


                    @if(session('error'))

                    <div class="alert alert-danger alert-dismissible fade show">

                        {{ session('error') }}

                        <button class="close" data-dismiss="alert">&times;</button>

                    </div>

                    @endif


                    {{-- Content --}}
                    @yield('content')


                </div>


            </div>


            {{-- ================= FOOTER ================= --}}

            <footer class="sticky-footer bg-white">

                <div class="container my-auto">

                    <div class="copyright text-center my-auto">

                        <span>
                            Copyright &copy; FitGym {{ date('Y') }}
                        </span>

                    </div>

                </div>

            </footer>


        </div>

    </div>


    {{-- Scroll --}}
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    {{-- JS --}}
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}"></script>


    @stack('scripts')

</body>

</html>