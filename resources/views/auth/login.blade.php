@extends('layouts.guest')

@section('title', 'Login')
@section('auth-title', 'Welcome Back')
@section('auth-subtitle', 'Sign in to your account to continue')

@section('content')
    <!-- Session Status -->
    @if (session('status'))
        <div class="auth-success">
            <i class="fas fa-check-circle status-icon"></i>
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">Email Address</label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   class="form-control @error('email') is-invalid @enderror" 
                   required 
                   autofocus 
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
                   autocomplete="current-password"
                   placeholder="Enter your password">
            @error('password')
                <div class="form-feedback is-invalid">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="auth-remember">
            <input id="remember_me" 
                   type="checkbox" 
                   name="remember" 
                   class="form-check-input">
            <label for="remember_me" class="form-check-label">Remember me</label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="auth-button auth-button-primary">
            <i class="fas fa-sign-in-alt"></i>
            <span>Sign In</span>
        </button>

        <!-- Forgot Password Link -->
        @if (Route::has('password.request'))
            <div class="text-center">
                <a href="{{ route('password.request') }}" class="auth-link">
                    Forgot your password?
                </a>
            </div>
        @endif
    </form>

    <!-- Register Link -->
    <div class="auth-links">
        <p class="text-muted">
            Don't have an account? 
            <a href="{{ route('register') }}" class="auth-link">
                Create one here
            </a>
        </p>
    </div>
@endsection