<!-- resources/views/admin/partials/sidebar.blade.php -->
 <style>
   
.custom-scrollbar {
    overflow-y: auto;
    max-height: calc(100vh - 180px); 
}

.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
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

.custom-scrollbar::-webkit-scrollbar {
    display: none; 
}

.custom-scrollbar {
    -ms-overflow-style: none; 
    scrollbar-width: none; 
}

.custom-scrollbar:hover::-webkit-scrollbar {
    display: block;
}

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

.icon-box {
    transition: all 0.3s;
}

.nav-link:hover .icon-box {
    transform: scale(1.1);
}

.sidebar .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
    transform: translateX(5px);
}

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
 </style>
<div class="sidebar bg-dark text-white shadow" style="width: 250px; min-height: 100vh; scrollbar-width: thin;">
    <div class="sidebar-content p-0 d-flex flex-column h-100">
        <!-- Logo and Title -->
        <div class="text-center p-3 border-bottom border-secondary">
            <div class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle mb-2" style="width: 60px; height: 60px;">
                <i class="fas fa-user-shield fa-2x text-white"></i>
            </div>
            <h5 class="mb-0">Administrator Control Panel</h5>
        </div>
        
        <!-- Navigation - with custom scrollbar -->
        <div class="sidebar-menu flex-grow-1 custom-scrollbar">
            <ul class="nav flex-column pt-2 px-2">
                <li class="nav-item mb-2">
                    <a class="nav-link text-white d-flex align-items-center rounded ps-3 {{ request()->routeIs('admin.dashboard') ? 'active bg-primary' : 'bg-transparent' }}" 
                       href="{{ route('admin.dashboard') }}">
                        <div class="icon-box me-3 rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 36px; height: 36px; background-color: {{ request()->routeIs('admin.dashboard') ? 'rgba(255, 255, 255, 0.2)' : 'rgba(255, 255, 255, 0.1)' }}">
                            <i class="fas fa-tachometer-alt"></i>
                        </div>
                        <span>Home</span>
                    </a>
                </li>
                
                <li class="nav-item mb-2">
                    <a class="nav-link text-white d-flex align-items-center rounded ps-3 {{ request()->routeIs('users.*') ? 'active bg-primary' : 'bg-transparent' }}" 
                       href="{{ route('users.index') }}">
                        <div class="icon-box me-3 rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 36px; height: 36px; background-color: {{ request()->routeIs('users.*') ? 'rgba(255, 255, 255, 0.2)' : 'rgba(255, 255, 255, 0.1)' }}">
                            <i class="fas fa-users"></i>
                        </div>
                        <span>User Management</span>
                    </a>
                </li>
                
                <li class="nav-item mb-2">
                    <a class="nav-link text-white d-flex align-items-center rounded ps-3 {{ request()->routeIs('dashboard.activities.*') ? 'active bg-primary' : 'bg-transparent' }}" 
                       href="{{ route('dashboard.activities.index') }}">
                        <div class="icon-box me-3 rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 36px; height: 36px; background-color: {{ request()->routeIs('dashboard.activities.*') ? 'rgba(255, 255, 255, 0.2)' : 'rgba(255, 255, 255, 0.1)' }}">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <span>Activities Management</span>
                    </a>
                </li>
                
                <li class="nav-item mb-2">
                    <a class="nav-link text-white d-flex align-items-center rounded ps-3 {{ request()->routeIs('dashboard.posts.*') ? 'active bg-primary' : 'bg-transparent' }}" 
                       href="{{ route('dashboard.posts.index') }}">
                        <div class="icon-box me-3 rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 36px; height: 36px; background-color: {{ request()->routeIs('dashboard.posts.*') ? 'rgba(255, 255, 255, 0.2)' : 'rgba(255, 255, 255, 0.1)' }};">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <span>Post Management</span>
                    </a>
                </li>
                
                <li class="nav-item mb-2">
                    <a class="nav-link text-white d-flex align-items-center rounded ps-3 {{ request()->routeIs('comments.*') ? 'active bg-primary' : 'bg-transparent' }}" 
                       href="{{ route('comments.index') }}">
                        <div class="icon-box me-3 rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 36px; height: 36px; background-color: {{ request()->routeIs('comments.*') ? 'rgba(255, 255, 255, 0.2)' : 'rgba(255, 255, 255, 0.1)' }};">
                            <i class="fas fa-comments"></i>
                        </div>
                        <span>Comments Management</span>
                    </a>
                </li>
                
                <li class="nav-item mb-2">
                    <a class="nav-link text-white d-flex align-items-center rounded ps-3 {{ request()->routeIs('donations.*') ? 'active bg-primary' : 'bg-transparent' }}" 
                       href="{{ route('donations.index') }}">
                        <div class="icon-box me-3 rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 36px; height: 36px; background-color: <?php echo request()->routeIs('donations.*') ? 'rgba(255, 255, 255, 0.2)' : 'rgba(255, 255, 255, 0.1)'; ?>">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <span>Donation Management</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- User Section with Logout -->
        <div class="mt-auto p-3 border-top border-secondary">
            <div class="d-flex align-items-center mb-3">
                <img src="https://ui-avatars.com/api/?name=Admin+User&background=primary&color=fff" 
                     class="rounded-circle me-2" width="40" height="40">
                <div>
                    <h6 class="mb-0">Admin User</h6>
                    <small class="text-white-50">Admin</small>
                </div>
            </div>
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-dark border border-secondary w-100 d-flex align-items-center justify-content-center">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </button>
            </form>
        </div>
    </div>
</div>