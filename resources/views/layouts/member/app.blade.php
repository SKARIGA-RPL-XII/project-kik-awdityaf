<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Member Area' }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
    .gym-primary {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    }

    .gym-accent {
        color: #00d4ff;
    }

    .gym-accent-secondary {
        color: #ff006e;
    }

    .btn-gym-primary {
        background-color: #00d4ff;
        color: #000;
        border: none;
        font-weight: bold;
    }

    .btn-gym-primary:hover {
        background-color: #00b8d4;
        color: #000;
    }

    .btn-gym-secondary {
        background-color: #ff006e;
        color: #fff;
        border: none;
        font-weight: bold;
    }

    .btn-gym-secondary:hover {
        background-color: #e60060;
        color: #fff;
    }

    .card-gym {
        border: none;
        background-color: #0f1419;
        border-left: 4px solid #00d4ff;
    }

    .card-gym:hover {
        box-shadow: 0 8px 24px rgba(0, 212, 255, 0.15);
    }
    </style>

    <style>
    :root {
        --gym-dark-1: #0f1419;
        --gym-dark-2: #16213e;
        --gym-cyan: #00d4ff;
        --gym-pink: #ff006e;
    }

    .sidebar {
        width: 240px;
        min-height: 100vh;
        background: linear-gradient(180deg, var(--gym-dark-1), var(--gym-dark-2));
        color: #e6eef2;
        padding-top: 12px;
    }

    .sidebar a {
        color: #dbeef6;
        display: block;
        padding: 12px 18px;
        border-left: 3px solid transparent;
    }

    .sidebar a:hover {
        background: rgba(0, 212, 255, 0.04);
        color: var(--gym-cyan);
        text-decoration: none;
        border-left-color: var(--gym-cyan);
    }

    .main-content {
        margin-left: 10px;
        padding: 24px;
        background: transparent;
        color: #fff;
    }

    /* Gym theme helpers */
    .gym-accent {
        color: var(--gym-cyan);
    }

    .gym-accent-secondary {
        color: var(--gym-pink);
    }

    .btn-gym-primary {
        background-color: var(--gym-cyan);
        color: #000;
        border: none;
        font-weight: 700;
    }

    .btn-gym-primary:hover {
        background-color: #00b8d4;
    }

    .btn-gym-secondary {
        background-color: var(--gym-pink);
        color: #fff;
        border: none;
        font-weight: 700;
    }

    .card-gym {
        border: none;
        background-color: rgba(15, 20, 25, 0.8);
        border-left: 4px solid var(--gym-cyan);
    }

    .text-light {
        color: #dbeef6 !important;
    }
    </style>

    @stack('styles')
</head>

<body class="bg-light">

    <div class="d-flex">

        {{-- Sidebar --}}
        @include('layouts.member.sidebar')

        <div class="flex-grow-1">

            {{-- Navbar --}}
            @include('layouts.member.navbar')

            {{-- Content --}}
            <div class="main-content">

                {{-- Alert --}}
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if(session('warning'))
                <div class="alert alert-warning">{{ session('warning') }}</div>
                @endif

                @yield('content')

            </div>

        </div>

    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

</body>

</html>