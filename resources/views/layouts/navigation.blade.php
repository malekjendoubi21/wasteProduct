<nav class="navbar">
    <div class="navbar-container">
        <!-- Brand -->
        <a href="{{ route('home') }}" class="navbar-brand">
            <div class="navbar-logo">
                <i class="fas fa-recycle"></i>
            </div>
            <span class="navbar-brand-text">Waste Product</span>
        </a>

        <!-- Desktop Navigation -->
        <ul class="navbar-nav">
            <li><a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a></li>
            
            <li><a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
                <i class="fas fa-info-circle"></i>
                <span>About</span>
            </a></li>
            
            <li><a href="{{ route('produits.index') }}" class="nav-link {{ request()->routeIs('produits.*') ? 'active' : '' }}">
                <i class="fas fa-box"></i>
                <span>Produits</span>
            </a></li>
            
            <li><a href="{{ route('services') }}" class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}">
                <i class="fas fa-cogs"></i>
                <span>Services</span>
            </a></li>
            
            <li><a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">
                <i class="fas fa-envelope"></i>
                <span>Contact</span>
            </a></li>
            @auth
                <li>
                    <a href="{{ route('front.orders.create') }}" class="nav-link {{ request()->routeIs('front.orders.create') ? 'active' : '' }}">
                        <i class="fas fa-cart-plus"></i>
                        <span>Commander</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('front.orders.index') }}" class="nav-link {{ request()->routeIs('front.orders.*') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Mes commandes</span>
                    </a>
                </li>
            @endauth
        </ul>

        <!-- User Menu -->
        <div class="navbar-user">
            @auth
                @php(
                    $hasNotificationsTable = \Illuminate\Support\Facades\Schema::hasTable('notifications')
                )
                @php(
                    $unread = $hasNotificationsTable ? auth()->user()->unreadNotifications()->limit(5)->get() : collect()
                )
                @php(
                    $unreadCount = $hasNotificationsTable ? auth()->user()->unreadNotifications()->count() : 0
                )
                <div class="dropdown me-3">
                    <a href="{{ route('notifications.index') }}" class="dropdown-toggle user-profile-link" title="Notifications">
                        <i class="fas fa-bell"></i>
                        @if($unreadCount > 0)
                            <span class="badge bg-danger" style="position:relative; top:-10px; left:-10px;">{{ $unreadCount }}</span>
                        @endif
                    </a>
                </div>
                <div class="dropdown">
                    <a href="{{ route('profile.show') }}" class="dropdown-toggle user-profile-link">
                        <div class="user-avatar">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="user-info">
                            <div class="user-name">{{ auth()->user()->name }}</div>
                            <div class="user-role">{{ ucfirst(auth()->user()->role ?? 'User') }}</div>
                        </div>
                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                    </a>
                    
                    <div class="dropdown-menu">
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <i class="fas fa-user"></i>
                            <span>Profile</span>
                        </a>
                        
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('dashboard') }}" class="dropdown-item">
                                <i class="fas fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a>
                        @endif
                        
                        <div class="dropdown-divider"></div>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Login</span>
                </a>
            @endauth
        </div>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" aria-label="Toggle navigation">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div class="navbar-collapse">
        <ul class="navbar-nav">
            <li><a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a></li>
            
            <li><a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
                <i class="fas fa-info-circle"></i>
                <span>About</span>
            </a></li>
            
            <li><a href="{{ route('produits.index') }}" class="nav-link {{ request()->routeIs('produits.*') ? 'active' : '' }}">
                <i class="fas fa-box"></i>
                <span>Produits</span>
            </a></li>
            
            <li><a href="{{ route('services') }}" class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}">
                <i class="fas fa-cogs"></i>
                <span>Services</span>
            </a></li>
            
            <li><a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">
                <i class="fas fa-envelope"></i>
                <span>Contact</span>
            </a></li>
            
            @auth
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        <div class="user-avatar">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="user-info">
                            <div class="user-name">{{ auth()->user()->name }}</div>
                            <div class="user-role">{{ ucfirst(auth()->user()->role ?? 'User') }}</div>
                        </div>
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    
                    <div class="dropdown-menu">
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <i class="fas fa-user"></i>
                            <span>Profile</span>
                        </a>
                        
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('dashboard') }}" class="dropdown-item">
                                <i class="fas fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a>
                        @endif
                        
                        <div class="dropdown-divider"></div>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Login</span>
                </a>
            @endauth
        </ul>
    </div>
</nav>