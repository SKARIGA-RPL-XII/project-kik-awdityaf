<aside class="w-64 min-h-screen fixed" style="background: linear-gradient(180deg,#0f1419,#16213e); color: #e6eef2;">

    <style>
        :root {
            --gym-cyan: #00d4ff;
            --gym-pink: #ff006e;
        }

        .admin-link {
            display: block;
            padding: 12px 18px;
            color: #dbeef6;
            border-left: 4px solid transparent;
        }

        .admin-link:hover {
            background: rgba(0, 212, 255, 0.03);
            color: var(--gym-cyan);
            border-left-color: var(--gym-cyan);
        }

        .gym-accent {
            color: var(--gym-cyan);
        }
    </style>

    <!-- Logo -->
    <div class="p-5 text-center" style="border-bottom: 1px solid rgba(255,255,255,0.04);">
        <h2 class="text-xl font-bold gym-accent"><i class="fas fa-shield-alt mr-2"></i>Gym Admin</h2>
    </div>


    <!-- Menu -->
    <nav class="mt-4">
        <ul class="space-y-1">

            <li>
                <a href="{{ route('admin.dashboard') }}" class="admin-link">
                    <i class="fas fa-chart-line mr-2 gym-accent"></i> Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('admin.members') }}" class="admin-link">
                    <i class="fas fa-users mr-2" style="color: var(--gym-pink);"></i> Members
                </a>
            </li>

            <li>
                <a href="{{ route('admin.plans') }}" class="admin-link">
                    <i class="fas fa-tags mr-2 gym-accent"></i> Member Plans
                </a>
            </li>

            <li>
                <a href="{{ route('admin.attendance') }}" class="admin-link">
                    <i class="fas fa-clock mr-2" style="color: var(--gym-pink);"></i> Attendance
                </a>
            </li>

            <li>
                <a href="{{ route('admin.reports') }}" class="admin-link">
                    <i class="fas fa-file-alt mr-2 gym-accent"></i> Reports
                </a>
            </li>

            <li>
                <a href="{{ route('admin.settings') }}" class="admin-link">
                    <i class="fas fa-cog mr-2 gym-accent"></i> Settings
                </a>
            </li>

        </ul>
    </nav>

</aside>