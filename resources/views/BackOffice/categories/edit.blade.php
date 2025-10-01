@extends('layouts.backoffice')

@section('title', ' - Edit Category')

@section('content')
<div class="dashboard-header">
  <div class="dashboard-header-content">
    <h1 class="dashboard-title">Edit Category</h1>
  </div>
</div>
<div class="dashboard-content">
  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{ route('categories.update', $categorie) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
          <label class="form-label">Name</label>
          <input type="text" name="libelle" class="form-control" value="{{ old('libelle', $categorie->libelle) }}" required>
          @error('libelle')<div class="text-danger text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Image</label>
          @if($categorie->image_url)
            <div class="mb-2">
              <img src="{{ $categorie->image_url }}" alt="{{ $categorie->libelle }}" style="max-height:120px">
            </div>
          @endif
          <input type="file" name="image" accept="image/*" class="form-control">
          @error('image')<div class="text-danger text-sm">{{ $message }}</div>@enderror
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>
@endsection
