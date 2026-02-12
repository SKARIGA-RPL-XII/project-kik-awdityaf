<div class="sidebar">

    <div class="text-center py-1 border-bottom" style="border-color: rgba(255,255,255,0.04);">
        <h5 class="mb-0 text-light"><i class="fas fa-dumbbell mr-2 gym-accent"></i>MEMBER FITGYM</h5>
        <small class="text-light">{{ auth()->user()->name ?? '' }}</small>
    </div>

    <nav class="mt-3">

        <a href="{{ route('member.dashboard') }}">
            <i class="fas fa-home mr-2 gym-accent"></i> <span class="text-light">Dashboard</span>
        </a>

        <a href="{{ url('member/plans') }}">
            <i class="fas fa-tags mr-2" style="color: var(--gym-pink);"></i> <span class="text-light">Membership
                Plans</span>
        </a>

        <a href="{{ url('member/subscriptions') }}">
            <i class="fas fa-credit-card mr-2 gym-accent"></i> <span class="text-light">My Subscriptions</span>
        </a>

        <a href="{{ url('member/attendance') }}">
            <i class="fas fa-calendar mr-2" style="color: var(--gym-pink);"></i> <span class="text-light">My
                Attendance</span>
        </a>

        <a href="{{ url('member/profile') }}">
            <i class="fas fa-user mr-2 gym-accent"></i> <span class="text-light">My Profile</span>
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