@extends('layouts.app')

@section('title', ' - Profile')

@section('content')
<div class="profile-layout">
    <div class="profile-container">
        <!-- Profile Information Card -->
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="profile-info">
                    <h1 class="profile-title">{{ auth()->user()->name }}</h1>
                    <p class="profile-subtitle">{{ auth()->user()->email }}</p>
                    <p class="profile-meta">Member since {{ auth()->user()->created_at->format('F Y') }}</p>
                </div>
            </div>
            
            <div class="profile-body">
                <div class="profile-section">
                    <h3 class="profile-section-title">Personal Information</h3>
                    <div class="profile-details">
                        <div class="profile-detail-item">
                            <span class="profile-detail-label">Full Name:</span>
                            <span class="profile-detail-value">{{ auth()->user()->name }}</span>
                        </div>
                        <div class="profile-detail-item">
                            <span class="profile-detail-label">Email Address:</span>
                            <span class="profile-detail-value">{{ auth()->user()->email }}</span>
                        </div>
                        <div class="profile-detail-item">
                            <span class="profile-detail-label">Email Verified:</span>
                            <span class="profile-detail-value">
                                @if(auth()->user()->email_verified_at)
                                    <span class="badge bg-success">Verified</span>
                                @else
                                    <span class="badge bg-warning">Not Verified</span>
                                @endif
                            </span>
                        </div>
                        <div class="profile-detail-item">
                            <span class="profile-detail-label">Account Created:</span>
                            <span class="profile-detail-value">{{ auth()->user()->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="profile-detail-item">
                            <span class="profile-detail-label">Last Updated:</span>
                            <span class="profile-detail-value">{{ auth()->user()->updated_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="profile-section">
                    <h3 class="profile-section-title">Account Statistics</h3>
                    <div class="profile-stats">
                        <div class="profile-stat-item">
                            <div class="profile-stat-number">0</div>
                            <div class="profile-stat-label">Orders Placed</div>
                        </div>
                        <div class="profile-stat-item">
                            <div class="profile-stat-number">0</div>
                            <div class="profile-stat-label">Products Recycled</div>
                        </div>
                        <div class="profile-stat-item">
                            <div class="profile-stat-number">0</div>
                            <div class="profile-stat-label">Points Earned</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Profile Actions -->
            <div class="profile-actions">
                <a href="{{ route('profile.edit') }}" class="profile-button profile-button-primary">
                    <i class="fas fa-edit"></i>
                    <span>Edit Profile</span>
                </a>
                <a href="{{ route('dashboard') }}" class="profile-button profile-button-secondary">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
