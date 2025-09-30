@extends('layouts.guest')

@section('title', 'Register')
@section('auth-title', 'Create Account')
@section('auth-subtitle', 'Join us and start your journey')

@section('content')
    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name" class="form-label">Full Name</label>
            <input id="name" 
                   type="text" 
                   name="name" 
                   value="{{ old('name') }}" 
                   class="form-control @error('name') is-invalid @enderror" 
                   required 
                   autofocus 
                   autocomplete="name"
                   placeholder="Enter your full name">
            @error('name')
                <div class="form-feedback is-invalid">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">Email Address</label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   class="form-control @error('email') is-invalid @enderror" 
                   required 
                   autocomplete="username"
                   placeholder="Enter your email">
            @error('email')
                <div class="form-feedback is-invalid">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input id="password" 
                   type="password" 
                   name="password" 
                   class="form-control @error('password') is-invalid @enderror" 
                   required 
                   autocomplete="new-password"
                   placeholder="Create a password">
            @error('password')
                <div class="form-feedback is-invalid">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input id="password_confirmation" 
                   type="password" 
                   name="password_confirmation" 
                   class="form-control" 
                   required 
                   autocomplete="new-password"
                   placeholder="Confirm your password">
        </div>

        <!-- Terms and Conditions -->
        <div class="auth-remember">
            <input id="terms" 
                   type="checkbox" 
                   name="terms" 
                   class="form-check-input" 
                   required>
            <label for="terms" class="form-check-label">
                I agree to the <a href="#" class="auth-link">Terms of Service</a> and <a href="#" class="auth-link">Privacy Policy</a>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="auth-button auth-button-primary">
            <i class="fas fa-user-plus"></i>
            <span>Create Account</span>
        </button>
    </form>

    <!-- Login Link -->
    <div class="auth-links">
        <p class="text-muted">
            Already have an account? 
            <a href="{{ route('login') }}" class="auth-link">
                Sign in here
            </a>
        </p>
    </div>
@endsection