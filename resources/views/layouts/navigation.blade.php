<style>
    :root {
        --primary-color: #2ebf91;
        --secondary-color: #F8ED8C;
        --accent-color: #FF8989;
        --hover-color: hsl(70, 70%, 67%);
    }

    .dropdown-item:active {
        background-color: var(--primary-color);
    }

    .brand-color {
        color: var(--primary-color);
    }

    .brand-color:hover {
        color: var(--primary-color);
    }

    .btn-primary-custom {
        background-color: var(--primary-color);
        border: none;
        color: white;
    }

    .btn-primary-custom:hover {
        background-color: var(--hover-color);
        color: white;
    }

    .nav-link:hover {
        color: var(--hover-color) !important;
    }
</style>

<nav
    class="navbar d-flex justify-content-around navbar-expand-lg navbar-light bg-white border-bottom shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold brand-color" href="{{ route('home') }}">Grow</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarGrow"
            aria-controls="navbarGrow" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between align-items-center" id="navbarGrow">
            <!-- Left: Brand Spacer -->
            <div class="d-none d-lg-block" style="width: 140px;"></div>

            <!-- Center: Navigation Links -->
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 text-center">
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('activities.index') }}">Activities</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('posts.index') }}">Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('about') }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('contact') }}">Contact Us</a>
                </li>
            </ul>

            <!-- Right: Auth -->
            <div class="d-flex align-items-center ms-auto">
                @auth
                    <ul class="navbar-nav d-flex align-items-center">
                        <li class="nav-item me-2">
                            @if(Auth::user()->profile_image)
                                <!-- Show actual profile image -->
                                <img src="{{ asset(Auth::user()->profile_image) }}" alt="Profile" class="rounded-circle"
                                    style="width: 32px; height: 32px; object-fit: cover;">
                            @else
                                <!-- Fallback to initials in SVG circle -->
                                <div
                                    style="width: 32px; height: 32px; background-color: #2ebf91; border-radius: 50%; display: flex; justify-content: center; align-items: center; color: white; font-weight: bold; font-size: 12px;">
                                    {{ strtoupper(substr(Auth::user()->first_name, 0, 1) . substr(Auth::user()->last_name ?? '', 0, 1)) }}
                                </div>
                            @endif
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-dark" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Welcome, {{ Auth::user()->first_name }}!
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item" type="submit">Log Out</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary-custom ms-3">Log In</a>
                @endauth
            </div>
            
        </div>

    </div>
</nav>

<!-- Bootstrap JS (required for navbar toggle and dropdowns) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>