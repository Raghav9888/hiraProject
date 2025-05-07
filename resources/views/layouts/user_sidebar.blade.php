<!-- Sidebar -->
<style>
    body {
        background-color: #f5f7fa;
    }

    .sidebar {
        background-color: #ffffff;
        min-height: 100vh;
        padding-top: 2rem;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
    }

    .sidebar a {
        color: #333;
        display: block;
        padding: 12px 20px;
        text-decoration: none;
    }

    .sidebar a:hover, .sidebar a.active {
        background-color: #f0f0f0;
        font-weight: bold;
    }

    .card {
        border: none;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.04);
    }
</style>
<nav class="col-md-3 col-lg-2 sidebar py-4">
    <h5 class="mb-4 text-center">👤 User Panel</h5>

    <div class="w-100 px-3">
        <a href="{{route('userDashboard')}}" class="d-block py-2 px-3 rounded mb-1 text-decoration-none {{ request()->routeIs('userDashboard') ? 'active' : '' }}">
            <i class="bi bi-house me-2"></i> Dashboard
        </a>

        <a href="{{route('userBookings')}}" class="d-block py-2 px-3 rounded mb-1 text-decoration-none {{ request()->routeIs('userBookings') ? 'active' : '' }}">
            <i class="bi bi-calendar-check me-2"></i> My Bookings
        </a>

        <a href="#" class="d-block py-2 px-3 rounded mb-3 text-decoration-none">
            <i class="bi bi-person me-2"></i> Favorites
        </a>

        <a href="{{route('userProfile')}}" class="d-block py-2 px-3 rounded mb-3 text-decoration-none {{ request()->routeIs('userProfile') ? 'active' : '' }}">
            <i class="bi bi-person me-2"></i> Profile
        </a>

        <!-- Logout as a styled link -->
        <form action="{{ route('logout') }}" method="POST" class="d-block">
            @csrf
            <button type="submit" class="d-block w-100 text-start border-0 bg-transparent py-2 px-3 text-danger">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </button>
        </form>
    </div>
</nav>

