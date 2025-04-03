<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name') }}</title>
 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    
    <!-- Standard LTR Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            direction: ltr;
            text-align: left;
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0; /* Left side sidebar for LTR layout */
            height: 100%;
            z-index: 100;
        }
        
        .main-content {
            margin-left: 250px; /* Left margin for content in LTR layout */
            margin-right: 0;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100% !important;
                height: auto;
            }
            
            .main-content {
                margin-left: 0;
                margin-right: 0;
            }
        }
        
        .nav-link {
            padding: 0.5rem 1rem;
            border-radius: 5px;
            margin-bottom: 5px;
        }
        
        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .card-dashboard {
            transition: all 0.3s;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .card-dashboard:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        /* Ensure dropdown menus open on the right side */
        .dropdown-menu-end {
            right: 0;
            left: auto;
        }
        
        /* Ensure all text elements have proper LTR alignment */
        .text-start {
            text-align: left !important;
        }
        
        .text-end {
            text-align: right !important;
        }
        
        /* Fix form controls for LTR */
        .form-group label {
            text-align: left;
        }
        
        /* Fix button icons for LTR */
        .me-2 {
            margin-right: 0.5rem !important;
            margin-left: 0 !important;
        }
        
        .ms-auto {
            margin-left: auto !important;
            margin-right: 0 !important;
        }
        
        .ms-2 {
            margin-left: 0.5rem !important;
            margin-right: 0 !important;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="d-flex">
      
        @include('admin.partials.sidebar')
     
        <div class="main-content flex-grow-1 p-4">
          
            <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 rounded shadow-sm">
                <div class="container-fluid">
                    <h5 class="mb-0">@yield('page-title', 'Control panel')</h5>
                    
                    <div class="ms-auto d-flex align-items-center">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=random" class="rounded-circle me-2" width="30" height="30">
                                {{ auth()->user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
            
            <!-- Page Content -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
      
            
            @yield('content')
        </div>
    </div>
    
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>