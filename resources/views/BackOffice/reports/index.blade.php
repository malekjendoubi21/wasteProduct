@extends('layouts.backoffice')

@section('title', ' - Reports & Analytics')

@section('content')
    <div class="dashboard-header">
        <div class="dashboard-header-content">
            <h1 class="dashboard-title">Reports & Analytics</h1>
            <p class="dashboard-subtitle">View detailed reports and analytics for your business</p>
        </div>
        <div class="dashboard-header-actions">
            <button class="btn btn-primary">
                <i class="fas fa-download"></i>
                <span>Export Report</span>
            </button>
        </div>
    </div>

    <div class="dashboard-content">
        <!-- Report Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Total Sales</h6>
                                <h4 class="mb-0">$12,450</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Active Users</h6>
                                <h4 class="mb-0">1,234</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-box"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Products</h6>
                                <h4 class="mb-0">456</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Orders</h6>
                                <h4 class="mb-0">789</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reports Table -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Available Reports</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Report Name</th>
                                <th>Description</th>
                                <th>Last Generated</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Sales Report</td>
                                <td>Monthly sales performance and trends</td>
                                <td>2024-01-20</td>
                                <td><span class="badge bg-success">Ready</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                    <button class="btn btn-sm btn-outline-success">Download</button>
                                </td>
                            </tr>
                            <tr>
                                <td>User Activity Report</td>
                                <td>User engagement and activity metrics</td>
                                <td>2024-01-19</td>
                                <td><span class="badge bg-success">Ready</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                    <button class="btn btn-sm btn-outline-success">Download</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Product Performance</td>
                                <td>Product sales and performance analysis</td>
                                <td>Generating...</td>
                                <td><span class="badge bg-warning">Processing</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary" disabled>View</button>
                                    <button class="btn btn-sm btn-outline-secondary" disabled>Download</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
