@extends('layouts.backoffice')

@section('title', ' - Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back, ' . auth()->user()->name . '!')

@section('content')
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card primary">
            <div class="stat-card-content">
                <div class="stat-card-info">
                    <div class="stat-card-title">Total Users</div>
                    <div class="stat-card-value">2,543</div>
                    <div class="stat-card-change positive">
                        <i class="fas fa-arrow-up"></i>
                        <span>+12.5%</span>
                    </div>
                </div>
                <div class="stat-card-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        <div class="stat-card success">
            <div class="stat-card-content">
                <div class="stat-card-info">
                    <div class="stat-card-title">Products Recycled</div>
                    <div class="stat-card-value">15,847</div>
                    <div class="stat-card-change positive">
                        <i class="fas fa-arrow-up"></i>
                        <span>+8.2%</span>
                    </div>
                </div>
                <div class="stat-card-icon">
                    <i class="fas fa-recycle"></i>
                </div>
            </div>
        </div>

        <div class="stat-card warning">
            <div class="stat-card-content">
                <div class="stat-card-info">
                    <div class="stat-card-title">Pending Orders</div>
                    <div class="stat-card-value">127</div>
                    <div class="stat-card-change negative">
                        <i class="fas fa-arrow-down"></i>
                        <span>-3.1%</span>
                    </div>
                </div>
                <div class="stat-card-icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>

        <div class="stat-card error">
            <div class="stat-card-content">
                <div class="stat-card-info">
                    <div class="stat-card-title">Revenue</div>
                    <div class="stat-card-value">$45,231</div>
                    <div class="stat-card-change positive">
                        <i class="fas fa-arrow-up"></i>
                        <span>+15.3%</span>
                    </div>
                </div>
                <div class="stat-card-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="dashboard-charts">
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">Recycling Trends</h3>
            </div>
            <div class="chart-placeholder">
                <i class="fas fa-chart-line"></i>
                <p>Chart visualization would go here</p>
            </div>
        </div>

        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">Waste Categories</h3>
            </div>
            <div class="chart-placeholder">
                <i class="fas fa-chart-pie"></i>
                <p>Pie chart would go here</p>
            </div>
        </div>
    </div>
@endsection
