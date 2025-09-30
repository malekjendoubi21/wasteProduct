@extends('layouts.app')

@section('title', ' - Services')

@section('content')
    <!-- Services Section -->
    <section class="services-section">
        <div class="container">
            <div class="section-header">
                <div class="section-badge">
                    <i class="fas fa-cogs"></i>
                    <span>Our Services</span>
                </div>
                <h2 class="section-title">How We Help You</h2>
                <p class="section-subtitle">
                    We provide comprehensive waste management solutions that benefit both you and the environment.
                </p>
            </div>
            
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <div class="icon-bg"></div>
                        <div class="icon-wrapper">
                            <i class="fas fa-recycle"></i>
                        </div>
                    </div>
                    <h3 class="service-title">Waste Collection</h3>
                    <p class="service-description">
                        We collect various types of waste from your location with our professional team and eco-friendly vehicles.
                    </p>
                    <ul class="service-features">
                        <li>Scheduled pickups</li>
                        <li>Multiple waste categories</li>
                        <li>Real-time tracking</li>
                    </ul>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">
                        <div class="icon-bg"></div>
                        <div class="icon-wrapper">
                            <i class="fas fa-leaf"></i>
                        </div>
                    </div>
                    <h3 class="service-title">Eco Processing</h3>
                    <p class="service-description">
                        Our advanced processing facilities ensure maximum recycling and minimal environmental impact.
                    </p>
                    <ul class="service-features">
                        <li>Zero waste to landfill</li>
                        <li>Energy-efficient processing</li>
                        <li>Quality assurance</li>
                    </ul>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">
                        <div class="icon-bg"></div>
                        <div class="icon-wrapper">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                    <h3 class="service-title">Analytics & Reports</h3>
                    <p class="service-description">
                        Get detailed insights about your waste management with comprehensive analytics and reporting.
                    </p>
                    <ul class="service-features">
                        <li>Real-time dashboards</li>
                        <li>Custom reports</li>
                        <li>Performance metrics</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
