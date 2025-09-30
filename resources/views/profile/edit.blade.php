@extends('layouts.app')

@section('title', ' - Profile')

@section('content')
<div class="profile-layout">
    <div class="profile-container">
        <!-- Profile Information Card -->
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <h1 class="profile-title">{{ auth()->user()->name }}</h1>
                <p class="profile-subtitle">{{ auth()->user()->email }}</p>
            </div>
            
            <div class="profile-body">
                @if (session('status') === 'profile-updated')
                    <div class="status-message status-success">
                        <i class="fas fa-check-circle status-icon"></i>
                        <span>Profile updated successfully!</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" class="profile-form">
                    @csrf
                    @method('patch')

                    <!-- Name -->
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input id="name" 
                               name="name" 
                               type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', auth()->user()->name) }}" 
                               required 
                               autofocus 
                               autocomplete="name">
                        @error('name')
                            <div class="form-feedback is-invalid">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" 
                               name="email" 
                               type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', auth()->user()->email) }}" 
                               required 
                               autocomplete="username">
                        @error('email')
                            <div class="form-feedback is-invalid">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Profile Actions -->
                    <div class="profile-actions">
                        <button type="submit" class="profile-button profile-button-primary">
                            <i class="fas fa-save"></i>
                            <span>Save Changes</span>
                        </button>
                        
                        <a href="{{ route('profile.show') }}" class="profile-button profile-button-secondary">
                            <i class="fas fa-times"></i>
                            <span>Cancel</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Update Password Card -->
        <div class="profile-card">
            <div class="profile-header">
                <h1 class="profile-title">Update Password</h1>
                <p class="profile-subtitle">Ensure your account is using a long, random password to stay secure.</p>
            </div>
            
            <div class="profile-body">
                @if (session('status') === 'password-updated')
                    <div class="status-message status-success">
                        <i class="fas fa-check-circle status-icon"></i>
                        <span>Password updated successfully!</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}" class="profile-form">
                    @csrf
                    @method('put')

                    <!-- Current Password -->
                    <div class="form-group">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input id="current_password" 
                               name="current_password" 
                               type="password" 
                               class="form-control @error('current_password') is-invalid @enderror" 
                               autocomplete="current-password">
                        @error('current_password')
                            <div class="form-feedback is-invalid">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">New Password</label>
                        <input id="password" 
                               name="password" 
                               type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               autocomplete="new-password">
                        @error('password')
                            <div class="form-feedback is-invalid">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input id="password_confirmation" 
                               name="password_confirmation" 
                               type="password" 
                               class="form-control" 
                               autocomplete="new-password">
                    </div>

                    <!-- Password Actions -->
                    <div class="profile-actions">
                        <button type="submit" class="profile-button profile-button-primary">
                            <i class="fas fa-key"></i>
                            <span>Update Password</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Account Card -->
        <div class="profile-card danger-section">
            <div class="danger-header">
                <h1 class="danger-title">Delete Account</h1>
            </div>
            
            <div class="danger-body">
                <p class="danger-description">
                    Once your account is deleted, all of its resources and data will be permanently deleted. 
                    Before deleting your account, please download any data or information that you wish to retain.
                </p>
                
                <button class="profile-button profile-button-danger" data-modal="delete-account-modal">
                    <i class="fas fa-trash"></i>
                    <span>Delete Account</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div id="delete-account-modal" class="modal-overlay">
    <div class="modal-content modal-danger">
        <div class="modal-header">
            <h3 class="modal-title">Delete Account</h3>
            <button class="modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.</p>
            
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" 
                           name="password" 
                           type="password" 
                           class="form-control" 
                           placeholder="Password"
                           required>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" onclick="hideModal(document.getElementById('delete-account-modal'))">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-error">
                        Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection