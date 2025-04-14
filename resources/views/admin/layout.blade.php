<!-- resources/views/admin/layout.blade.php -->
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Admin Dashboard')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* تحسين مظهر السكرول في الـ sidebar */
        .custom-scrollbar {
            overflow-y: auto;
            max-height: calc(100vh - 180px); /* يتم ضبط هذه القيمة حسب حجم الهيدر والفوتر في الـ sidebar */
        }

        /* تخصيص شكل السكرول بار */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* إخفاء السكرول بار عندما لا يتم استخدامه */
        .custom-scrollbar {
            -ms-overflow-style: none; /* IE و Edge */
            scrollbar-width: none; /* Firefox */
        }

        .custom-scrollbar::-webkit-scrollbar {
            display: none; /* لـ Safari و Chrome */
        }

        /* عند تمرير الماوس فوق المنطقة نظهر السكرول بار */
        .sidebar:hover .custom-scrollbar::-webkit-scrollbar {
            display: block;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            z-index: 100;
            transition: all 0.3s;
            overflow: hidden;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .main-content {
            margin-left: 250px;
            transition: all 0.3s;
            min-height: 100vh;
            width: calc(100% - 250px);
            position: relative;
            padding: 20px;
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
                width: 100%;
            }
        }

        .nav-link {
            padding: 0.8rem 1rem;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.2s;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        /* تحسين مظهر القوائم النشطة والمؤشرات */
        .sidebar .nav-link {
            position: relative;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .sidebar .nav-link.active {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .sidebar .nav-link.active::before {
            content: '';
            position: absolute;
            left: -10px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 60%;
            background-color: #fff;
            border-radius: 0 4px 4px 0;
        }

        /* تحسين أيقونات القائمة */
        .icon-box {
            transition: all 0.3s;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-link:hover .icon-box {
            transform: scale(1.1);
        }

        .toggle-sidebar {
            display: none;
        }

        @media (max-width: 768px) {
            .toggle-sidebar {
                display: block;
            }
        }

        /* تحسين مظهر البطاقات في الداشبورد */
        .stat-card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 55px;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 1.5rem;
        }

        /* تحسين مظهر الجداول */
        .table-dashboard {
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-dashboard th {
            font-weight: 600;
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .table-dashboard td {
            vertical-align: middle;
        }

        .table-dashboard tr:hover {
            background-color: rgba(0, 123, 255, 0.03);
        }

        /* أزرار الإجراءات في الجداول */
        .action-buttons .btn {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            margin: 0 2px;
        }
        
        /* تحسين خلفية الألوان الخفيفة لتوافق Bootstrap 5.3 */
        .bg-primary-subtle {
            background-color: rgba(13, 110, 253, 0.1) !important;
        }
        
        .bg-success-subtle {
            background-color: rgba(25, 135, 84, 0.1) !important;
        }
        
        .bg-info-subtle {
            background-color: rgba(13, 202, 240, 0.1) !important;
        }
        
        .bg-warning-subtle {
            background-color: rgba(255, 193, 7, 0.1) !important;
        }
        
        .bg-danger-subtle {
            background-color: rgba(220, 53, 69, 0.1) !important;
        }
        
        .bg-secondary-subtle {
            background-color: rgba(108, 117, 125, 0.1) !important;
        }
        
        /* Fix for table responsiveness */
        .table-responsive {
            overflow-x: auto;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Main Content -->
        <div class="main-content">

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Mobile sidebar toggle
        document.getElementById('toggleSidebar').addEventListener('click', function () {
            document.querySelector('.sidebar').classList.toggle('active');
        });
    </script>
    
    @yield('scripts')
</body>

</html>