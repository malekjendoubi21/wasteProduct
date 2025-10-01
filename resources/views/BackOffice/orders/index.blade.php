@extends('layouts.backoffice')

@section('title', ' - Orders Management')

@section('content')
    <div class="dashboard-header">
        <div class="dashboard-header-content">
            <h1 class="dashboard-title">Orders Management</h1>
            <p class="dashboard-subtitle">Track and manage customer orders</p>
        </div>
        <div class="dashboard-header-actions">
            <a href="{{ route('commandes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                <span>New Order</span>
            </a>
        </div>
    </div>

    <div class="dashboard-content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Orders</h3>
                <div class="card-actions">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search orders..." class="search-input">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($commandes as $o)
                                <tr>
                                    <td>#{{ $o->id }}</td>
                                    <td>{{ optional($o->user)->name ?? '—' }}</td>
                                    <td>{{ number_format($o->montant, 2) }}</td>
                                    <td>{{ optional($o->date ?? $o->created_at)->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('commandes.show', $o) }}" class="btn btn-sm btn-outline-primary">View</a>
                                        <a href="{{ route('commandes.edit', $o) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                                        <form action="{{ route('commandes.destroy', $o) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this order?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No orders</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if(method_exists($commandes, 'links'))
        <div class="mt-4">{{ $commandes->links() }}</div>
    @endif
@endsection
