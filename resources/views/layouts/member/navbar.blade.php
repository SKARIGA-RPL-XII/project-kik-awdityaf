<nav class="navbar navbar-expand"
    style="background: linear-gradient(90deg, rgba(0,212,255,0.06), rgba(255,0,110,0.04)); border-bottom: 1px solid rgba(255,255,255,0.03);">

    <span class="navbar-brand font-bold ">
        <i class="fas fa-dumbbell mr-2 gym-accent"></i> Gym Membership
    </span>

    <ul class="navbar-nav text-bold ml-auto align-items-center">
        <li class="nav-item font-bold mr-3">
            <i class="fas fa-user-circle gym-accent"></i>
            <span class="ml-2">{{ auth()->user()->name ?? 'Member' }}</span>
        </li>

    </ul>

</nav>