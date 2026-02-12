<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Member Dashboard' }}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
    :root {
        --gym-dark-1: #0f1419;
        --gym-dark-2: #16213e;
        --gym-cyan: #00d4ff;
        --gym-pink: #ff006e;
    }

    body {
        background-color: var(--gym-dark-1);
        color: #dbeef6;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* ===== SIDEBAR (SAMA STRUKTUR ADMIN) ===== */
    .sidebar {
        width: 240px;
        min-height: 100vh;
        background: linear-gradient(180deg, var(--gym-dark-1), var(--gym-dark-2));
        color: #e6eef2;
        padding-top: 12px;
        position: fixed;
        left: 0;
        top: 0;
        z-index: 1000;
    }

    .sidebar a {
        color: #dbeef6;
        display: block;
        padding: 12px 18px;
        border-left: 3px solid transparent;
        text-decoration: none;
        transition: all 0.3s;
    }

    .sidebar a:hover {
        background: rgba(0, 212, 255, 0.04);
        color: var(--gym-cyan);
        border-left-color: var(--gym-cyan);
    }

    /* ===== NAVBAR ===== */
    .navbar-custom {
        background: linear-gradient(90deg, rgba(0, 212, 255, 0.06), rgba(255, 0, 110, 0.04));
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        margin-left: 240px;
        width: calc(100% - 240px);
    }

    /* ===== MAIN CONTENT ===== */
    .main-content {
        margin-left: 240px;
        padding: 24px;
        min-height: 100vh;
    }

    /* ===== THEME HELPERS ===== */
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
        color: #000;
    }

    .btn-gym-secondary {
        background-color: var(--gym-pink);
        color: #fff;
        border: none;
        font-weight: 700;
    }

    .btn-gym-secondary:hover {
        background-color: #e60060;
        color: #fff;
    }

    .card-gym {
        border: none;
        background-color: rgba(15, 20, 25, 0.6);
        border-left: 4px solid var(--gym-cyan);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .card-gym:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 212, 255, 0.15);
    }

    .text-light-custom {
        color: #dbeef6 !important;
    }

    .text-muted-custom {
        color: #aab2bd !important;
    }
    </style>

    @stack('styles')
</head>

<body>

    {{-- ===== SIDEBAR MEMBER ===== --}}
    <div class="sidebar">
        <div class="text-center py-3 border-bottom" style="border-color: rgba(255,255,255,0.04);">
            <h5 class="mb-0 text-light-custom font-weight-bold">
                <i class="fas fa-dumbbell mr-2 gym-accent"></i>FITGYM MEMBER
            </h5>
            <small class="text-muted-custom">
                {{ auth()->user()->name ?? 'Member' }}
            </small>
        </div>

        <nav class="mt-3">
            <a href="{{ route('member.dashboard') }}">
                <i class="fas fa-home mr-2 gym-accent"></i> Dashboard
            </a>

            <a href="{{ url('member/plans') }}">
                <i class="fas fa-tags mr-2" style="color: var(--gym-pink);"></i> Membership Plans
            </a>

            <a href="{{ url('member/subscriptions') }}">
                <i class="fas fa-credit-card mr-2 gym-accent"></i> My Subscriptions
            </a>

            <a href="{{ url('member/attendance') }}">
                <i class="fas fa-calendar mr-2" style="color: var(--gym-pink);"></i> My Attendance
            </a>

            <a href="{{ url('member/profile') }}">
                <i class="fas fa-user mr-2 gym-accent"></i> My Profile
            </a>

            <hr class="bg-light">

            <form action="{{ route('logout') }}" method="POST" class="px-3">
                @csrf
                <button class="btn btn-sm btn-gym-secondary btn-block">
                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                </button>
            </form>
        </nav>
    </div>


    {{-- ===== NAVBAR ===== --}}
    <nav class="navbar navbar-expand navbar-custom px-4 py-3">
        <span class="navbar-brand font-weight-bold text-light-custom">
            <i class="fas fa-dumbbell mr-2 gym-accent"></i> Member Panel
        </span>

        <ul class="navbar-nav ml-auto align-items-center">
            <li class="nav-item">
                <span class="text-light-custom">
                    <i class="fas fa-user-circle gym-accent fa-lg"></i>
                    <span class="ml-2 font-weight-bold">
                        {{ auth()->user()->name ?? 'Member' }}
                    </span>
                </span>
            </li>
        </ul>
    </nav>


    {{-- ===== CONTENT ===== --}}
    <div class="main-content">

        @if(session('success'))
        <div class="alert alert-success border-0"
            style="background-color: rgba(40, 167, 69, 0.2); color: #28a745; border-left: 4px solid #28a745;">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger border-0"
            style="background-color: rgba(220, 53, 69, 0.2); color: #dc3545; border-left: 4px solid #dc3545;">
            {{ session('error') }}
        </div>
        @endif

        @yield('content')

    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @stack('scripts')
</body>

</html>