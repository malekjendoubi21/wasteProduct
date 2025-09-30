@extends('layouts.backoffice')

@section('title', ' - Settings')

@section('content')
    <div class="dashboard-header">
        <div class="dashboard-header-content">
            <h1 class="dashboard-title">System Settings</h1>
            <p class="dashboard-subtitle">Configure system preferences and options</p>
        </div>
    </div>

    <div class="dashboard-content">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">General Settings</h3>
                    </div>
                    <div class="card-body">
                        <form class="settings-form">
                            <div class="form-group">
                                <label for="site_name" class="form-label">Site Name</label>
                                <input type="text" id="site_name" name="site_name" class="form-control" value="Waste Product" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="site_email" class="form-label">Site Email</label>
                                <input type="email" id="site_email" name="site_email" class="form-control" value="admin@wasteproduct.com" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="site_phone" class="form-label">Contact Phone</label>
                                <input type="tel" id="site_phone" name="site_phone" class="form-control" value="+1 (555) 123-4567">
                            </div>
                            
                            <div class="form-group">
                                <label for="site_address" class="form-label">Address</label>
                                <textarea id="site_address" name="site_address" class="form-control form-textarea" rows="3">123 Eco Street, Green City, GC 12345</textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="currency" class="form-label">Default Currency</label>
                                <select id="currency" name="currency" class="form-control">
                                    <option value="USD" selected>USD - US Dollar</option>
                                    <option value="EUR">EUR - Euro</option>
                                    <option value="GBP">GBP - British Pound</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="timezone" class="form-label">Timezone</label>
                                <select id="timezone" name="timezone" class="form-control">
                                    <option value="UTC" selected>UTC</option>
                                    <option value="America/New_York">America/New_York</option>
                                    <option value="Europe/London">Europe/London</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                <span>Save Settings</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">System Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Version:</strong> 1.0.0
                        </div>
                        <div class="mb-3">
                            <strong>Laravel:</strong> {{ app()->version() }}
                        </div>
                        <div class="mb-3">
                            <strong>PHP:</strong> {{ PHP_VERSION }}
                        </div>
                        <div class="mb-3">
                            <strong>Environment:</strong> {{ app()->environment() }}
                        </div>
                        <div class="mb-3">
                            <strong>Debug Mode:</strong> 
                            <span class="badge {{ config('app.debug') ? 'bg-warning' : 'bg-success' }}">
                                {{ config('app.debug') ? 'Enabled' : 'Disabled' }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Quick Actions</h3>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-outline-primary w-100 mb-2">
                            <i class="fas fa-database"></i>
                            <span>Backup Database</span>
                        </button>
                        <button class="btn btn-outline-warning w-100 mb-2">
                            <i class="fas fa-sync"></i>
                            <span>Clear Cache</span>
                        </button>
                        <button class="btn btn-outline-danger w-100">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Reset Settings</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
