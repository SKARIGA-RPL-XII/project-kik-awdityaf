<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    {{-- CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}">

    <title>Freedash Template</title>

    {{-- Datatables --}}
    <link rel="stylesheet" href="{{ asset('assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/extra-libs/datatables.net-bs4/css/responsive.dataTables.min.css') }}">

    {{-- Dropzone --}}
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css">

    {{-- Daterangepicker --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

    {{-- Main CSS --}}
    <link rel="stylesheet" href="{{ asset('dist/css/style.min.css') }}">

    <style>
    .dropzone .dz-preview .dz-progress {
        display: none !important;
    }

    .dropzone {
        border: 1px solid #e9ecef;
    }
    </style>
</head>

<body>

    {{-- Preloader --}}
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <div id="main-wrapper">

        {{-- HEADER --}}
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-lg">

                <div class="navbar-header">

                    <div class="navbar-brand">
                        <a href="{{ url('/dashboard') }}">
                            <img src="{{ asset('assets/images/freedashDark.svg') }}" class="img-fluid">
                        </a>
                    </div>

                </div>

                <div class="navbar-collapse collapse">

                    <ul class="navbar-nav ms-auto">

                        {{-- Profile --}}
                        <li class="nav-item dropdown">

                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">

                                <img src="{{ asset('assets/images/users/profile-pic.jpg') }}" class="rounded-circle"
                                    width="40">

                                <span class="ms-2 text-dark">
                                    Jason Doe
                                </span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">

                                <a class="dropdown-item" href="#">
                                    My Profile
                                </a>

                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="{{ route('logout') }}">
                                    Logout
                                </a>

                            </div>
                        </li>

                    </ul>

                </div>
            </nav>
        </header>


        {{-- SIDEBAR --}}
        <aside class="left-sidebar">

            <div class="scroll-sidebar">

                <nav class="sidebar-nav">

                    <ul id="sidebarnav">

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ url('/dashboard') }}">
                                <i data-feather="home"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>


                        <li class="nav-small-cap">
                            Fitur Utama
                        </li>


                        {{-- MASTER --}}
                        <li class="sidebar-item">

                            <a class="sidebar-link has-arrow" href="#">
                                <i data-feather="settings"></i>
                                <span>Master</span>
                            </a>

                            <ul class="collapse">

                                <li>
                                    <a href="{{ url('/master/inhabitant') }}">
                                        Penduduk
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ url('/master/admin') }}">
                                        Admin
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ url('/master/lettercategory') }}">
                                        Kategori Surat
                                    </a>
                                </li>

                            </ul>
                        </li>


                        {{-- ARSIP --}}
                        <li class="sidebar-item">

                            <a class="sidebar-link has-arrow" href="#">
                                <i data-feather="file-text"></i>
                                <span>Arsip</span>
                            </a>

                            <ul class="collapse">

                                <li>
                                    <a href="{{ url('/letters/incoming') }}">
                                        Surat Masuk
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ url('/letters/outgoing') }}">
                                        Surat Keluar
                                    </a>
                                </li>

                            </ul>
                        </li>

                    </ul>

                </nav>

            </div>

        </aside>


        {{-- CONTENT --}}
        <div class="page-wrapper">

            @yield('content')


            {{-- FOOTER --}}
            <footer class="footer text-center text-muted">
                All Rights Reserved by Freedash.
            </footer>

        </div>

    </div>


    {{-- JS --}}
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>

    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('dist/js/app-style-switcher.js') }}"></script>

    <script src="{{ asset('dist/js/feather.min.js') }}"></script>

    <script src="{{ asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>

    <script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>

    <script src="{{ asset('dist/js/custom.min.js') }}"></script>


    {{-- Datatable --}}
    <script src="{{ asset('assets/extra-libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>

    <script src="{{ asset('assets/extra-libs/datatables.net-bs4/js/dataTables.responsive.min.js') }}"></script>


    {{-- Sweetalert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    {{-- CSRF Ajax --}}
    <script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    </script>


    {{-- Datatable Init --}}
    <script>
    $('table.datatables').DataTable({
        responsive: true,
        autoWidth: false,
    });
    </script>


    {{-- Delete Function --}}
    <script>
    function deleteData(id, url) {

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {

            if (result.isConfirmed) {

                $.post(url, {
                    id: id
                }, function(res) {

                    Swal.fire('Berhasil', res.message, 'success');

                    location.reload();

                });

            }

        });

    }
    </script>

</body>

</html>