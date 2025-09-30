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
                    <span>Solutions Écologiques</span>
                </div>
                
                <h1 class="hero-title">
                    Transformez les déchets en 
                    <span class="text-gradient">Valeur</span>
                </h1>
                
                <p class="hero-subtitle">
                    Rejoignez notre plateforme de gestion durable des déchets et transformez vos déchets en ressources précieuses. 
                    Ensemble, nous pouvons créer un avenir plus propre et plus vert.
                </p>
                
                <div class="hero-actions">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-rocket"></i>
                        <span>Commencer</span>
                    </a>
                    <a href="#services" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-play"></i>
                        <span>En savoir plus</span>
                    </a>
                </div>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number">10K+</div>
                        <div class="stat-label">Utilisateurs Actifs</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">50K+</div>
                        <div class="stat-label">Produits Recyclés</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">95%</div>
                        <div class="stat-label">Taux de Réussite</div>
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
                    <span>Nos Services</span>
                </div>
                <h2 class="section-title">Comment Nous Vous Aidons</h2>
                <p class="section-subtitle">
                    Nous proposons des solutions complètes de gestion des déchets qui profitent à la fois à vous et à l'environnement.
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
                    <h3 class="service-title">Collecte des Déchets</h3>
                    <p class="service-description">
                        Nous collectons différents types de déchets à votre emplacement avec notre équipe professionnelle et nos véhicules écologiques.
                    </p>
                    <ul class="service-features">
                        <li>Collectes programmées</li>
                        <li>Catégories de déchets multiples</li>
                        <li>Suivi en temps réel</li>
                    </ul>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">
                        <div class="icon-bg"></div>
                        <div class="icon-wrapper">
                            <i class="fas fa-leaf"></i>
                        </div>
                    </div>
                    <h3 class="service-title">Traitement Écologique</h3>
                    <p class="service-description">
                        Nos installations de traitement avancées garantissent un recyclage maximal et un impact environnemental minimal.
                    </p>
                    <ul class="service-features">
                        <li>Zéro déchet en décharge</li>
                        <li>Traitement économe en énergie</li>
                        <li>Assurance qualité</li>
                    </ul>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">
                        <div class="icon-bg"></div>
                        <div class="icon-wrapper">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                    <h3 class="service-title">Analytique & Rapports</h3>
                    <p class="service-description">
                        Obtenez des informations détaillées sur votre gestion des déchets grâce à des analyses et rapports complets.
                    </p>
                    <ul class="service-features">
                        <li>Tableaux de bord en temps réel</li>
                        <li>Rapports personnalisés</li>
                        <li>Mesures de performance</li>
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
                    <h2 class="impact-title">Notre Impact Environnemental</h2>
                    <p class="impact-description">
                        Depuis notre lancement, nous avons eu un impact positif significatif sur l'environnement. 
                        Notre plateforme a aidé à réduire les déchets et à promouvoir des pratiques durables dans les communautés.
                    </p>
                    
                    <div class="impact-stats">
                        <div class="impact-stat">
                            <div class="stat-number-large">78%</div>
                            <div class="stat-label">Réduction des Déchets</div>
                            <div class="stat-description">Par rapport aux méthodes traditionnelles</div>
                        </div>
                        <div class="impact-stat">
                            <div class="stat-number-large">2.5M</div>
                            <div class="stat-label">Tonnes Recyclées</div>
                            <div class="stat-description">Total des déchets traités</div>
                        </div>
                        <div class="impact-stat">
                            <div class="stat-number-large">15K</div>
                            <div class="stat-label">Arbres Sauvés</div>
                            <div class="stat-description">Grâce au recyclage du papier</div>
                        </div>
                    </div>
                </div>
                
                <div class="impact-visual">
                    <div class="impact-chart">
                        <div class="chart-circle">
                            <div class="chart-content">
                                <div class="chart-percentage">78%</div>
                                <div class="chart-label">Taux de Recyclage</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Partenaires -->
    <section id="partenaires" class="partners-section">
        <div class="container">
            <div class="section-header">
                <div class="section-badge">
                    <i class="fas fa-handshake"></i>
                    <span>Nos Partenaires</span>
                </div>
                <h2 class="section-title">Nos Partenaires de Confiance</h2>
                <p class="section-subtitle">
                    Nous collaborons avec des organisations de premier plan pour améliorer nos solutions de gestion durable des déchets.
                </p>
            </div>
            
            <div class="partners-grid">
                <div class="partner-card animate-slide-in" style="--delay: 0.2s;">
                    <div class="partner-logo">
                        <img src="{{ asset('images/partners/greentech.png') }}" alt="GreenTech Solutions">
                    </div>
                    <h3 class="partner-title">GreenTech Solutions</h3>
                    <p class="partner-description">
                        Innovateurs en technologies écologiques, fournissant des équipements de recyclage de pointe.
                    </p>
                    <a href="#" class="partner-link">En savoir plus</a>
                </div>
                
                <div class="partner-card animate-slide-in" style="--delay: 0.4s;">
                    <div class="partner-logo">
                        <img src="{{ asset('images/partners/ecocycle.png') }}" alt="EcoCycle Works">
                    </div>
                    <h3 class="partner-title">EcoCycle Works</h3>
                    <p class="partner-description">
                        Experts en traitement des déchets, nous aidant à atteindre l'objectif de zéro déchet en décharge.
                    </p>
                    <a href="#" class="partner-link">En savoir plus</a>
                </div>
                
                <div class="partner-card animate-slide-in" style="--delay: 0.6s;">
                    <div class="partner-logo">
                        <img src="{{ asset('images/partners/sustainco.png') }}" alt="SustainCo">
                    </div>
                    <h3 class="partner-title">SustainCo</h3>
                    <p class="partner-description">
                        Leaders en conseil en durabilité, guidant nos stratégies environnementales.
                    </p>
                    <a href="#" class="partner-link">En savoir plus</a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">Prêt à Faire la Différence ?</h2>
                <p class="cta-subtitle">
                    Rejoignez des milliers d'utilisateurs qui ont déjà un impact positif sur l'environnement. 
                    Commencez votre parcours de gestion des déchets aujourd'hui.
                </p>
                
                <div class="cta-actions">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-user-plus"></i>
                        <span>Commencer Gratuitement</span>
                    </a>
                    <a href="" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-phone"></i>
                        <span>Contactez les Ventes</span>
                    </a>
                </div>
                
                <div class="cta-features">
                    <div class="feature-item">
                        <i class="fas fa-check feature-icon"></i>
                        <span>Gratuit pour commencer</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check feature-icon"></i>
                        <span>Aucun frais d'installation</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check feature-icon"></i>
                        <span>Support 24/7</span>
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