<style>
    .brand-color {
        color: #F4A261;
    }

    .btn-primary-custom {
        background-color: #F4A261;
        border: none;
        color: white;
    }

    .btn-primary-custom:hover {
        background-color: #e28f50;
        color: white;
    }

    .nav-link:hover {
        color: #F4A261 !important;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold brand-color" href="#">Grow</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarGrow" aria-controls="navbarGrow" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarGrow">
            <!-- Centered nav links -->
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">Activities</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('posts.index') }}">Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('contact.show') }}">Contact Us</a>
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
