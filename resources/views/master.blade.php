{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Dashboard')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images.png') }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extra-libs/datatables.net-bs4/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="{{ asset('dist/css/style.min.css') }}">

    @stack('styles')

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

    <!-- Preloader -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">

        {{-- HEADER --}}
        @include('layouts.partials.header')

        {{-- SIDEBAR --}}
        @include('layouts.partials.sidebar')

        {{-- CONTENT --}}
        <div class="page-wrapper">

            <div class="container-fluid">
                @yield('content')
            </div>

            {{-- FOOTER --}}
            <footer class="footer text-center text-muted">
                All Rights Reserved by Freedash.
            </footer>
        </div>
    </div>

    <div id="ModalGlobal" class="modal fade" tabindex="-1"></div>

    <!-- JS -->
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('dist/js/app-style-switcher.js') }}"></script>
    <script src="{{ asset('dist/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/sparkline/sparkline.js') }}"></script>
    <script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('dist/js/custom.min.js') }}"></script>
    <script src="{{ asset('dist/js/ajax-request.js') }}"></script>

    <script src="{{ asset('assets/extra-libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/datatables.net-bs4/js/dataTables.responsive.min.js') }}"></script>

    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    @stack('scripts')

    <script>
    Dropzone.autoDiscover = false;

    $(function() {
        $('table.datatables').DataTable({
            responsive: true,
            autoWidth: false,
        });
    });

    function deleteData(id, url) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {

            if (result.isConfirmed) {

                $.post(url, {
                        _token: '{{ csrf_token() }}',
                        id: id
                    })
                    .done(function(response) {

                        if (response.RESULT === 'OK') {
                            Swal.fire('Berhasil', response.MESSAGE, 'success')
                                .then(() => location.reload());
                        } else {
                            Swal.fire('Gagal', response.MESSAGE, 'error');
                        }

                    })
                    .fail(function() {
                        Swal.fire('Gagal', 'Server sedang sibuk!', 'error');
                    });
            }
        });
    }
    </script>

</body>

</html>