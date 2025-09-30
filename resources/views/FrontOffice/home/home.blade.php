@extends('layouts.app')

@section('title', ' - Home')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <div class="hero-badge">
                    <i class="fas fa-leaf"></i>
                    <span>Eco-Friendly Solutions</span>
                </div>
                
                <h1 class="hero-title">
                    Transform Waste into 
                    <span class="text-gradient">Value</span>
                </h1>
                
                <p class="hero-subtitle">
                    Join our sustainable waste management platform and turn your waste products into valuable resources. 
                    Together, we can create a cleaner, greener future.
                </p>
                
                <div class="hero-actions">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-rocket"></i>
                        <span>Get Started</span>
                    </a>
                    <a href="#services" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-play"></i>
                        <span>Learn More</span>
                    </a>
                </div>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number">10K+</div>
                        <div class="stat-label">Active Users</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">50K+</div>
                        <div class="stat-label">Products Recycled</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">95%</div>
                        <div class="stat-label">Success Rate</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services-section">
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

    <!-- Impact Section -->
    <section class="impact-section">
        <div class="container">
            <div class="impact-grid">
                <div class="impact-content">
                    <h2 class="impact-title">Our Environmental Impact</h2>
                    <p class="impact-description">
                        Since our launch, we've made a significant positive impact on the environment. 
                        Our platform has helped reduce waste and promote sustainable practices across communities.
                    </p>
                    
                    <div class="impact-stats">
                        <div class="impact-stat">
                            <div class="stat-number-large">78%</div>
                            <div class="stat-label">Waste Reduction</div>
                            <div class="stat-description">Compared to traditional methods</div>
                        </div>
                        <div class="impact-stat">
                            <div class="stat-number-large">2.5M</div>
                            <div class="stat-label">Tons Recycled</div>
                            <div class="stat-description">Total waste processed</div>
                        </div>
                        <div class="impact-stat">
                            <div class="stat-number-large">15K</div>
                            <div class="stat-label">Trees Saved</div>
                            <div class="stat-description">Through paper recycling</div>
                        </div>
                    </div>
                </div>
                
                <div class="impact-visual">
                    <div class="impact-chart">
                        <div class="chart-circle">
                            <div class="chart-content">
                                <div class="chart-percentage">78%</div>
                                <div class="chart-label">Recycling Rate</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">Ready to Make a Difference?</h2>
                <p class="cta-subtitle">
                    Join thousands of users who are already making a positive impact on the environment. 
                    Start your waste management journey today.
                </p>
                
                <div class="cta-actions">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-user-plus"></i>
                        <span>Get Started Free</span>
                    </a>
                    <a href="" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-phone"></i>
                        <span>Contact Sales</span>
                    </a>
                </div>
                
                <div class="cta-features">
                    <div class="feature-item">
                        <i class="fas fa-check feature-icon"></i>
                        <span>Free to start</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check feature-icon"></i>
                        <span>No setup fees</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check feature-icon"></i>
                        <span>24/7 support</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Animate stats on scroll
const observerOptions = {
    threshold: 0.5,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            animateNumbers(entry.target);
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

document.querySelectorAll('.stat-number, .stat-number-large').forEach(el => {
    observer.observe(el);
});

function animateNumbers(element) {
    const finalNumber = parseInt(element.textContent.replace(/[^\d]/g, ''));
    const duration = 2000;
    const increment = finalNumber / (duration / 16);
    let current = 0;
    
    const timer = setInterval(() => {
        current += increment;
        if (current >= finalNumber) {
            current = finalNumber;
            clearInterval(timer);
        }
        
        const suffix = element.textContent.replace(/[\d]/g, '');
        element.textContent = Math.floor(current).toLocaleString() + suffix;
    }, 16);
}
</script>
@endpush