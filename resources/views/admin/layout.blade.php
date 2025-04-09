<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <title>@yield('title')</title>

    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            z-index: 100;
            transition: all 0.3s;
        }

        .main-content {
            margin-left: 250px;
            transition: all 0.3s;
        }

        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
            }

            .sidebar.active {
                margin-left: 0;
            }

            .main-content {
                margin-left: 0;
            }
        }

        .nav-link {
            padding: 0.8rem 1rem;
            border-radius: 5px;
            margin-bottom: 5px;
            transition: all 0.2s;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateX(5px);
        }

        .card-dashboard {
            transition: all 0.3s;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .card-dashboard:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .toggle-sidebar {
            display: none;
        }

        @media (max-width: 768px) {
            .toggle-sidebar {
                display: block;
            }
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Include the Sidebar -->
        @include('admin.partials.sidebar')
        <div class="w-100">
            <!-- Include the navbar -->
            @include('admin.partials.adminNavbar')

            <!-- Main Content -->
            <main>
                @yield('content')
            </main>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>