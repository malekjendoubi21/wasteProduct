@extends('layouts.backoffice')

@section('title', ' - Categories Management')

@section('content')
    <div class="dashboard-header">
        <div class="dashboard-header-content">
            <h1 class="dashboard-title">Categories Management</h1>
            <p class="dashboard-subtitle">Manage product categories and classifications</p>
        </div>
        <div class="dashboard-header-actions">
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                <span>Add Category</span>
            </a>
        </div>
    </div>

    <div class="dashboard-content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Categories</h3>
                <div class="card-actions">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search categories..." class="search-input">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Products Count</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $c)
                                <tr>
                                    <td>{{ $c->id }}</td>
                                    <td>
                                        @if($c->image_url)
                                            <img src="{{ $c->image_url }}" alt="{{ $c->libelle }}" style="height:48px;width:auto">
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>{{ $c->libelle }}</td>
                                    <td>{{ $c->produits_count }}</td>
                                    <td>{{ optional($c->date_creation ?? $c->created_at)->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('categories.edit', $c) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form action="{{ route('categories.destroy', $c) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this category?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No categories</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if(method_exists($categories, 'links'))
        <div class="mt-4">{{ $categories->links() }}</div>
    @endif
@endsection
