<nav class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center shadow-md">
    <style>
        :root {
            --gym-dark-1: #0f1419;
            --gym-dark-2: #16213e;
            --gym-cyan: #00d4ff;
            --gym-pink: #ff006e;
        }

        .gym-accent {
            color: var(--gym-cyan);
        }

        .gym-admin-bar {
            background: linear-gradient(90deg, rgba(0, 212, 255, 0.04), rgba(255, 0, 110, 0.03));
        }
    </style>
    <!-- Left -->
    <div class="flex items-center space-x-3">
        <span class="text-xl font-bold gym-accent"><i class="fas fa-shield-alt mr-2"></i>Admin Panel</span>
    </div>


    <!-- Right -->
    <div class="flex items-center space-x-4">
        <span class="text-sm text-gray-200">Hi, <strong class="gym-accent">{{ Auth::user()->name ?? 'Admin' }}</strong></span>


        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                <i class="fas fa-sign-out-alt mr-1"></i> Logout
            </button>
        </form>
    </div>
</nav>