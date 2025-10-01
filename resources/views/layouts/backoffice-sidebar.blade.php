<aside class="dashboard-sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <div class="sidebar-logo">
                <i class="fas fa-recycle"></i>
            </div>
            <span class="sidebar-brand-text">Waste Product</span>
        </a>
        
        <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <nav class="sidebar-nav">
        <div class="sidebar-nav-item">
            <a href="{{ route('dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt sidebar-nav-icon"></i>
                <span class="sidebar-nav-text">Dashboard</span>
            </a>
        </div>

        <div class="sidebar-nav-item">
            <a href="{{ route('users.index') }}" class="sidebar-nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="fas fa-users sidebar-nav-icon"></i>
                <span class="sidebar-nav-text">Users</span>
            </a>
        </div>
        
        <div class="sidebar-nav-item">
            <a href="{{ route('demandeListes.index') }}" class="sidebar-nav-link {{ request()->routeIs('demandeListes.*') ? 'active' : '' }}">
                <i class="fas fa-handshake sidebar-nav-icon"></i>
                    <span class="sidebar-nav-text">Demandes partenariat</span>
            </a>
        </div>

        <div class="sidebar-nav-item">
            <a href="{{ route('products.index') }}" class="sidebar-nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                <i class="fas fa-box sidebar-nav-icon"></i>
                <span class="sidebar-nav-text">Products</span>
            </a>
        </div>

        <div class="sidebar-nav-item">
            <a href="{{ route('categories.index') }}" class="sidebar-nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <i class="fas fa-tags sidebar-nav-icon"></i>
                <span class="sidebar-nav-text">Categories</span>
            </a>
        </div>

        <div class="sidebar-nav-item">
            <a href="{{ route('orders.index') }}" class="sidebar-nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart sidebar-nav-icon"></i>
                <span class="sidebar-nav-text">Orders</span>
            </a>
        </div>
        <div class="sidebar-nav-item">
            <a href="{{ route('evenements.index') }}" class="sidebar-nav-link {{ request()->routeIs('evenements.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt sidebar-nav-icon"></i>
            <span class="sidebar-nav-text">Evenements</span>
            </a>
        </div>
        <div class="sidebar-nav-item">
            <a href="{{ route('livraisons.index') }}" class="sidebar-nav-link {{ request()->routeIs('livraisons.*') ? 'active' : '' }}">
                <i class="fas fa-truck sidebar-nav-icon"></i>
                <span class="sidebar-nav-text">Livraisons</span>
            </a>
        </div>

        <div class="sidebar-nav-item">
            <a href="{{ route('trajets.index') }}" class="sidebar-nav-link {{ request()->routeIs('trajets.*') ? 'active' : '' }}">
                <i class="fas fa-route sidebar-nav-icon"></i>
                <span class="sidebar-nav-text">Trajets</span>
            </a>
        </div>

        <div class="sidebar-nav-item">
            <a href="{{ route('vehicules.index') }}" class="sidebar-nav-link {{ request()->routeIs('vehicules.*') ? 'active' : '' }}">
                <i class="fas fa-van-shuttle sidebar-nav-icon"></i>
                <span class="sidebar-nav-text">Véhicules</span>
            </a>
        </div>

        <div class="sidebar-nav-item">
            <a href="{{ route('reports.index') }}" class="sidebar-nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar sidebar-nav-icon"></i>
                <span class="sidebar-nav-text">Reports</span>
            </a>
        </div>

        <div class="sidebar-nav-item">
            <a href="{{ route('settings.index') }}" class="sidebar-nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                <i class="fas fa-cog sidebar-nav-icon"></i>
                <span class="sidebar-nav-text">Settings</span>
            </a>
        </div>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-user-avatar">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                <div class="sidebar-user-role">{{ ucfirst(auth()->user()->role ?? 'Admin') }}</div>
            </div>
        </div>
        
        <a href="{{ route('logout') }}" class="sidebar-logout" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
        
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</aside>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const dashboardMain = document.querySelector('.dashboard-main');
    
    // Load saved state
    const isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
    if (isCollapsed) {
        sidebar.classList.add('collapsed');
        dashboardMain.classList.add('sidebar-collapsed');
    }
    
    // Toggle sidebar
    sidebarToggle.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
        dashboardMain.classList.toggle('sidebar-collapsed');
        
        // Save state
        localStorage.setItem('sidebar-collapsed', sidebar.classList.contains('collapsed'));
    });
});
</script>