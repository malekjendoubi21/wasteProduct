@extends('layouts.app')

@section('title', ' - About Us')

@section('content')
    <!-- About Section -->
    <section class="services-section">
        <div class="container">
            <div class="section-header">
                <div class="section-badge">
                    <i class="fas fa-info-circle"></i>
                    <span>About Us</span>
                </div>
                <h2 class="section-title">About Waste Product</h2>
                <p class="section-subtitle">
                    We are committed to transforming waste into valuable resources for a sustainable future.
                </p>
            </div>
            
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-lg mb-4">
                                Waste Product was born from a simple mission: <strong>transforming waste into useful resources</strong>.
                                We believe in a world where nothing is lost and where every resource can have a second life.
                            </p>
                            
                            <p class="text-lg mb-4">
                                Our platform brings together:
                            </p>
                            
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <i class="fas fa-check-circle text-success me-3"></i>
                                    <strong>Recycled products</strong> accessible to everyone
                                </li>
                                <li class="mb-3">
                                    <i class="fas fa-check-circle text-success me-3"></i>
                                    A <strong>solidarity donation system</strong> to associations and beneficiaries
                                </li>
                                <li class="mb-3">
                                    <i class="fas fa-check-circle text-success me-3"></i>
                                    <strong>Ecological events</strong> to raise community awareness
                                </li>
                                <li class="mb-3">
                                    <i class="fas fa-check-circle text-success me-3"></i>
                                    <strong>Partnerships</strong> with responsible companies
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="h3 mb-3">Our Vision</h3>
                            <p class="lead text-muted">
                                Building a sustainable future by combining <span class="text-success font-weight-bold">innovation, solidarity and ecology</span>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection