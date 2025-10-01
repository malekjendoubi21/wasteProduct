@extends('layouts.app')

@section('title', 'Mes dons')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-center">Mes dons</h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($donations->isEmpty())
            <div class="alert alert-info text-center">
                Vous n'avez aucun don pour le moment.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Date</th>
                            <th scope="col">Association</th>
                            <th scope="col">Produits</th>
                            <th scope="col">Statut</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($donations as $donation)
                            <tr>
                                <td>
                                    @foreach ($donation->items as $item)
                                        @if ($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->nom }}" class="img-thumbnail" style="max-width: 80px; max-height: 80px;">
                                        @else
                                            <img src="{{ asset('images/placeholder.jpg') }}" alt="Placeholder" class="img-thumbnail" style="max-width: 80px; max-height: 80px;">
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $donation->formatted_date }}</td>
                                <td>{{ $donation->association->name }}</td>
                                <td>
                                    @foreach ($donation->items as $item)
                                        {{ $item->product->nom }} ({{ $item->quantity }})<br>
                                    @endforeach
                                </td>
                                <td>
                                    <span class="badge bg-{{ $donation->status === \App\Models\Donation::STATUS_PENDING ? 'warning' : ($donation->status === \App\Models\Donation::STATUS_ACCEPTED ? 'success' : 'info') }}">
                                        {{ $donation->status_label }}
                                    </span>
                                </td>
                                <td>
                                    @if ($donation->status === \App\Models\Donation::STATUS_PENDING)
                                        <a href="{{ route('donations.edit', $donation) }}" class="btn btn-warning btn-sm me-1" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('donations.destroy', $donation) }}" method="POST" style="display:inline;" onsubmit="return confirm('Voulez-vous vraiment supprimer ce don ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $donations->links('pagination::bootstrap-5') }}
            </div>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('produits.index') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-arrow-left me-2"></i>Retour aux produits
            </a>
        </div>
    </div>
@endsection