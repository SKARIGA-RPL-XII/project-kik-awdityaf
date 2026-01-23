<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Gym Management System">
    <meta name="author" content="FitGym">

    <title><?= $title; ?> - FitGym Admin</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom gym styles -->
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

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('gym'); ?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-dumbbell"></i>
                </div>
                <div class="sidebar-brand-text mx-3">FitGym <sup>Admin</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li
                class="nav-item <?= ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'index') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= base_url('gym'); ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Member Management
            </div>

            <!-- Nav Item - Members -->
            <li class="nav-item <?= ($this->uri->segment(2) == 'members') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= base_url('gym/members'); ?>">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Members</span></a>
            </li>

            <!-- Nav Item - Membership Plans -->
            <li class="nav-item <?= ($this->uri->segment(2) == 'membership_plans') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= base_url('gym/membership_plans'); ?>">
                    <i class="fas fa-fw fa-tags"></i>
                    <span>Membership Plans</span></a>
            </li>

            <!-- Nav Item - Subscriptions -->
            <li class="nav-item <?= ($this->uri->segment(2) == 'subscriptions') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= base_url('gym/subscriptions'); ?>">
                    <i class="fas fa-fw fa-credit-card"></i>
                    <span>Subscriptions</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Operations
            </div>

            <!-- Nav Item - Attendance -->
            <li class="nav-item <?= ($this->uri->segment(2) == 'attendance') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= base_url('gym/attendance'); ?>">
                    <i class="fas fa-fw fa-calendar-check"></i>
                    <span>Attendance</span></a>
            </li>

            <!-- Nav Item - Reports (Collapsed) -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReports"
                    aria-expanded="true" aria-controls="collapseReports">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Reports</span>
                </a>
                <div id="collapseReports"
                    class="collapse <?= (in_array($this->uri->segment(2), ['income_report', 'expense_report', 'member_report'])) ? 'show' : ''; ?>"
                    aria-labelledby="headingReports" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Financial Reports:</h6>
                        <a class="collapse-item <?= ($this->uri->segment(2) == 'income_report') ? 'active' : ''; ?>"
                            href="<?= base_url('gym/income_report'); ?>">
                            <i class="fas fa-arrow-up text-success mr-2"></i>Uang Masuk
                        </a>
                        <a class="collapse-item <?= ($this->uri->segment(2) == 'expense_report') ? 'active' : ''; ?>"
                            href="<?= base_url('gym/expense_report'); ?>">
                            <i class="fas fa-arrow-down text-danger mr-2"></i>Uang Keluar
                        </a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Member Reports:</h6>
                        <a class="collapse-item <?= ($this->uri->segment(2) == 'member_report') ? 'active' : ''; ?>"
                            href="<?= base_url('gym/member_report'); ?>">
                            <i class="fas fa-users text-info mr-2"></i>Laporan Member
                        </a>
                    </div>
                </div>
            </li>



            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small"
                                placeholder="Search for members..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-success" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php
                                $current_user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
                                ?>
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $current_user['name'] ?? 'Admin'; ?></span>
                                <img class="img-profile rounded-circle"
                                    src="<?= base_url('assets/img/profile/' . ($current_user['image'] ?? 'default.jpg')); ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= base_url('gym/profile'); ?>">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="<?= base_url('gym/change_password'); ?>">
                                    <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Change Password
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
                    </div>

                    <!-- Flash Messages -->
                    <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('success'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('error'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php endif; ?>

                    <!-- Content -->
                    <?php $this->load->view($content); ?>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; FitGym <?= date('Y'); ?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-success" href="<?= base_url('auth/logout'); ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?= base_url('assets/'); ?>vendor/chart.js/Chart.min.js"></script>

</body>

</html>