@extends('layouts.backoffice')

@section('title', ' - Create Category')

@section('content')
<div class="dashboard-header">
  <div class="dashboard-header-content">
    <h1 class="dashboard-title">Create Category</h1>
  </div>
</div>
<div class="dashboard-content">
  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <label class="form-label">Name</label>
          <input type="text" name="libelle" class="form-control" value="{{ old('libelle') }}" required>
          @error('libelle')<div class="text-danger text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Image</label>
          <input type="file" name="image" accept="image/*" class="form-control">
          @error('image')<div class="text-danger text-sm">{{ $message }}</div>@enderror
        </div>
        <button class="btn btn-primary">Save</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>
@endsection
