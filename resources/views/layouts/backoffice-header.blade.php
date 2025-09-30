<header class="dashboard-header">
    <div class="dashboard-header-content">
        <div>
            <h1 class="dashboard-title">@yield('page-title', 'Dashboard')</h1>
            <p class="dashboard-subtitle">@yield('page-subtitle', 'Welcome back, ' . auth()->user()->name)</p>
        </div>
        
        <div class="dashboard-actions">
            <!-- Search -->
            <div class="relative">
                <input type="text" 
                       placeholder="Search..." 
                       class="form-control form-control-sm"
                       style="width: 200px;">
                <i class="fas fa-search absolute right-3 top-1/2 transform -translate-y-1/2 text-muted"></i>
            </div>
            
            <!-- Notifications -->
            <div class="dropdown">
                <button class="btn btn-icon" data-modal="notifications-modal">
                    <i class="fas fa-bell"></i>
                    <span class="absolute -top-1 -right-1 bg-error-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                </button>
            </div>
            
            <!-- User Menu -->
            <div class="dropdown">
                <a href="#" class="dropdown-toggle">
                    <div class="user-avatar">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="user-info">
                        <div class="user-name">{{ auth()->user()->name }}</div>
                        <div class="user-role">{{ ucfirst(auth()->user()->role ?? 'Admin') }}</div>
                    </div>
                    <i class="fas fa-chevron-down"></i>
                </a>
                
                <div class="dropdown-menu">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                    
                    <a href="{{ route('settings.index') }}" class="dropdown-item">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                    
                    <div class="dropdown-divider"></div>
                    
                    <a href="{{ route('home') }}" class="dropdown-item">
                        <i class="fas fa-home"></i>
                        <span>View Site</span>
                    </a>
                    
                    <div class="dropdown-divider"></div>
                    
                    <form method="POST" action="{{ route('logout') }}" class="dropdown-item">
                        @csrf
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Notifications Modal -->
<div id="notifications-modal" class="modal-overlay">
    <div class="modal-content modal-sm">
        <div class="modal-header">
            <h3 class="modal-title">Notifications</h3>
            <button class="modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <div class="space-y-4">
                <div class="flex items-start gap-3 p-3 bg-success-50 border border-success-200 rounded-lg">
                    <i class="fas fa-check-circle text-success-500 mt-1"></i>
                    <div>
                        <p class="text-sm font-medium text-success-800">New order received</p>
                        <p class="text-xs text-success-600">2 minutes ago</p>
                    </div>
                </div>
                
                <div class="flex items-start gap-3 p-3 bg-warning-50 border border-warning-200 rounded-lg">
                    <i class="fas fa-exclamation-triangle text-warning-500 mt-1"></i>
                    <div>
                        <p class="text-sm font-medium text-warning-800">Low stock alert</p>
                        <p class="text-xs text-warning-600">1 hour ago</p>
                    </div>
                </div>
                
                <div class="flex items-start gap-3 p-3 bg-primary-50 border border-primary-200 rounded-lg">
                    <i class="fas fa-info-circle text-primary-500 mt-1"></i>
                    <div>
                        <p class="text-sm font-medium text-primary-800">System update available</p>
                        <p class="text-xs text-primary-600">3 hours ago</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline-secondary" onclick="hideModal(document.getElementById('notifications-modal'))">
                Mark all as read
            </button>
        </div>
    </div>
</div>