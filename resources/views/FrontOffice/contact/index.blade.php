@extends('layouts.app')

@section('title', ' - Contact')

@section('content')
    <!-- Contact Section -->
    <section class="services-section">
        <div class="container">
            <div class="section-header">
                <div class="section-badge">
                    <i class="fas fa-envelope"></i>
                    <span>Contact Us</span>
                </div>
                <h2 class="section-title">Get In Touch</h2>
                <p class="section-subtitle">
                    Have questions about our waste management services? We'd love to hear from you.
                </p>
            </div>
            
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Send us a message</h3>
                        </div>
                        <div class="card-body">
                            <form class="profile-form">
                                <div class="form-group">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" id="name" name="name" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" id="email" name="email" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input type="text" id="subject" name="subject" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea id="message" name="message" class="form-control form-textarea" rows="5" required></textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i>
                                    <span>Send Message</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Contact Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <h5><i class="fas fa-map-marker-alt text-primary"></i> Address</h5>
                                <p>123 Eco Street<br>Green City, GC 12345</p>
                            </div>
                            
                            <div class="mb-4">
                                <h5><i class="fas fa-phone text-primary"></i> Phone</h5>
                                <p>+1 (555) 123-4567</p>
                            </div>
                            
                            <div class="mb-4">
                                <h5><i class="fas fa-envelope text-primary"></i> Email</h5>
                                <p>info@wasteproduct.com</p>
                            </div>
                            
                            <div class="mb-4">
                                <h5><i class="fas fa-clock text-primary"></i> Business Hours</h5>
                                <p>Monday - Friday: 9:00 AM - 6:00 PM<br>
                                Saturday: 10:00 AM - 4:00 PM<br>
                                Sunday: Closed</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
