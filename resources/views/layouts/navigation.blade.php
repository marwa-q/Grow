<style>
    
    :root {
    --primary-color: #2ebf91;
    --secondary-color: #F8ED8C;
    --accent-color: #FF8989;
    --hover-color: hsl(70, 70%, 67%);
    }

    .brand-color {
        color: var(--primary-color);
    }

    .brand-color:hover {
        color: var(--primary-color);
    }

    .btn-primary-custom {
        background-color: var(--primary-color) ;
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

<nav class="navbar d-flex justify-content-around navbar-expand-lg navbar-light bg-white border-bottom shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold brand-color" href="{{ route('home') }}">Grow</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarGrow" aria-controls="navbarGrow" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarGrow">
            <!-- nav links -->
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
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
            @auth
                <!-- Dropdown Menu for Logged-in User -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
</nav>

<!-- Bootstrap JS (required for navbar toggle and dropdowns) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
