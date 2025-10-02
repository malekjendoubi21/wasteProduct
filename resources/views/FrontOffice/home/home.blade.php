@extends('layouts.app')

@section('title', ' - Home')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section animate-slide-in" style="--delay: 0.2s;">
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
    <section id="services" class="services-section animate-slide-in" style="--delay: 0.4s;">
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
    <section class="impact-section animate-slide-in" style="--delay: 0.6s;">
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
<!-- Section Partenaires -->
<section id="partenaires" class="services-section animate-slide-in" style="--delay: 0.8s;">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">
                <i class="fas fa-handshake"></i>
                <span>Nos Partenaires</span>
            </div>
            <h2 class="section-title">Nos Partenaires de Confiance</h2>
            <p class="section-subtitle">
                Nous collaborons avec des organisations de premier plan pour renforcer nos solutions de gestion durable des déchets.
            </p>
        </div>

        

        <div class="partners-slider">
            <div class="partners-track d-flex flex-wrap justify-content-center gap-4">
                <!-- Logos partenaires -->
                @foreach(['carr.png','carr.png','carr.png','carr.png','carr.png','carr.png'] as $logo)
                    <div class="partner-logo text-center">
                        <div class="service-icon">
                            <div class="icon-bg"></div>
                            <div class="icon-wrapper">
                                <img src="{{ asset('images/'.$logo) }}" alt="Logo partenaire" class="partner-logo-img" loading="lazy">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>


        <!-- Bouton pour afficher le formulaire -->
        <div class="partner-cta text-center mt-4">
            <button id="demande-btn" class="btn btn-primary">Demander le partenariat</button>
        </div>

        <!-- Formulaire de demande (caché au départ) -->
        <div id="demande-form-container" class="mt-4" style="display:none;">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Formulaire de Partenariat</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('demande.partenariat.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="nom_organisation" class="form-label">Nom de l'organisation</label>
                            <input type="text" name="nom_organisation" id="nom_organisation" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="type_organisation" class="form-label">Type d'organisation</label>
                            <input type="text" name="type_organisation" id="type_organisation" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="secteur_activite" class="form-label">Secteur d'activité</label>
                            <input type="text" name="secteur_activite" id="secteur_activite" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="logo" class="form-label">Logo de l'organisation</label>
                            <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
                        </div>

                        <div class="form-group mb-3">
                            <label for="email_contact" class="form-label">Email de contact</label>
                            <input type="email" name="email_contact" id="email_contact" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="telephone_contact" class="form-label">Téléphone de contact</label>
                            <input type="text" name="telephone_contact" id="telephone_contact" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="site_web" class="form-label">Site web (optionnel)</label>
                            <input type="text" name="site_web" id="site_web" class="form-control">
                        </div>

                        <div class="form-group mb-3">
                            <label for="adresse" class="form-label">Adresse</label>
                            <input type="text" name="adresse" id="adresse" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea name="message" id="message" class="form-control" rows="5" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-paper-plane"></i> Envoyer la demande
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Script toggle formulaire -->
<script>
document.getElementById('demande-btn').addEventListener('click', function() {
    const formContainer = document.getElementById('demande-form-container');
    formContainer.style.display = formContainer.style.display === 'none' ? 'block' : 'none';
    this.textContent = formContainer.style.display === 'block' ? 'Fermer le formulaire' : 'Demander le partenariat';
});
</script>



    <!-- CTA Section -->
    <section class="cta-section animate-slide-in" style="--delay: 1.0s;">
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
                    <a href="#" class="btn btn-outline-primary btn-lg">
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

@push('styles')
<style>
/* Animation pour toutes les sections */
.animate-slide-in {
    opacity: 0;
    transform: translateY(20px);
    animation: slideIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
    animation-delay: var(--delay);
}

@keyframes slideIn {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Partenaires Grid - Horizontal Scroll */
.partners-grid {
    display: flex;
    overflow-x: auto;
    gap: var(--space-8);
    margin-top: var(--space-12);
    padding-bottom: var(--space-4);
    scroll-behavior: smooth;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: thin;
    scrollbar-color: var(--color-primary-500) var(--color-surface);
}

.partners-grid::-webkit-scrollbar {
    height: 8px;
}

.partners-grid::-webkit-scrollbar-track {
    background: var(--color-surface);
    border-radius: var(--radius-md);
}

.partners-grid::-webkit-scrollbar-thumb {
    background: var(--color-primary-500);
    border-radius: var(--radius-md);
}

.partners-grid .service-card {
    flex: 0 0 350px;
    min-width: 350px;
    background: var(--color-surface);
    border-radius: var(--radius-2xl);
    padding: var(--space-10);
    box-shadow: var(--shadow-sm);
    transition: all var(--transition-base);
    border: 1px solid var(--color-border);
    position: relative;
    overflow: hidden;
    text-align: center;
    height: 100%;
}

.partners-grid .service-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
}

.partners-grid .service-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(45deg, var(--color-primary-500), var(--color-primary-700));
    transform: scaleX(0);
    transition: transform var(--transition-base);
}

.partners-grid .service-card:hover::before {
    transform: scaleX(1);
}

.service-icon {
    margin-bottom: var(--space-6);
    position: relative;
}

.icon-wrapper {
    width: 6rem;
    height: 6rem;
    background: linear-gradient(45deg, var(--color-primary-500), var(--color-primary-700));
    border-radius: var(--radius-2xl);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    z-index: 2;
    overflow: hidden;
}

.icon-bg {
    position: absolute;
    top: -12px;
    left: -12px;
    width: 7.5rem;
    height: 7.5rem;
    background: rgba(34, 197, 94, 0.15);
    border-radius: var(--radius-3xl);
    z-index: 1;
}

.partner-logo-img {
    max-width: 100%;
    height: auto;
    object-fit: contain;
}

.service-title {
    font-size: var(--font-size-2xl);
    font-weight: var(--font-weight-bold);
    color: var(--color-text-primary);
    margin-bottom: var(--space-4);
}

.service-description {
    color: var(--color-text-secondary);
    line-height: var(--line-height-relaxed);
    margin-bottom: var(--space-6);
}

.service-features {
    list-style: none;
    padding: 0;
    margin: 0;
}

.service-features li {
    color: var(--color-text-primary);
    margin-bottom: var(--space-2);
    padding-left: var(--space-6);
    position: relative;
}

.service-features li::before {
    content: '✓';
    position: absolute;
    left: 0;
    color: var(--color-success-500);
    font-weight: var(--font-weight-bold);
}

.partner-cta {
    text-align: center;
    margin-top: var(--space-12);
}

.btn-primary {
    background: var(--color-primary-500);
    color: white;
    padding: var(--space-3) var(--space-6);
    border: none;
    border-radius: var(--radius-md);
    font-weight: var(--font-weight-semibold);
    transition: background var(--transition-base);
    text-decoration: none;
    display: inline-block;
}

.btn-primary:hover {
    background: var(--color-primary-700);
}

.btn-outline-primary {
    background: transparent;
    color: var(--color-primary-500);
    border: 2px solid var(--color-primary-500);
    padding: var(--space-3) var(--space-6);
    border-radius: var(--radius-md);
    font-weight: var(--font-weight-semibold);
    transition: all var(--transition-base);
    text-decoration: none;
    display: inline-block;
}

.btn-outline-primary:hover {
    background: var(--color-primary-500);
    color: white;
}

.btn-lg {
    padding: var(--space-4) var(--space-8);
    font-size: var(--font-size-lg);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .hero-title {
        font-size: var(--font-size-4xl);
    }
    
    .hero-stats {
        justify-content: center;
    }
    
    .services-grid {
        grid-template-columns: 1fr;
    }
    
    .impact-grid {
        grid-template-columns: 1fr;
        gap: var(--space-8);
    }
    
    .impact-content {
        padding-right: 0;
        text-align: center;
    }
    
    .impact-stats {
        grid-template-columns: 1fr;
    }
    
    .cta-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .hero-actions {
        justify-content: center;
    }

    .partners-grid {
        padding: 0 var(--space-4);
    }

    .partners-grid .service-card {
        flex: 0 0 300px;
        min-width: 300px;
        padding: var(--space-8);
    }

    .partner-cta .btn-primary {
        width: 100%;
        max-width: 300px;
    }
}
</style>
@endpush

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