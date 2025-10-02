modifier le design profesionlle @extends('layouts.backoffice')

@section('title', 'Gestion des dons - Admin')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-center">Gestion des dons</h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($donations->isEmpty())
            <div class="alert alert-info text-center">
                Aucun don enregistré pour le moment.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Date</th>
                            <th scope="col">Donateur</th>
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
                                        @php
                                            // Debug: Log product image path for troubleshooting
                                            \Illuminate\Support\Facades\Log::debug('Admin: Product image path', [
                                                'product_id' => $item->product->id,
                                                'image' => $item->product->image ?? 'No image'
                                            ]);
                                        @endphp
                                        @if ($item->product->image && \Illuminate\Support\Facades\Storage::exists('public/' . $item->product->image))
                                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                                 alt="{{ $item->product->nom }}"
                                                 class="img-thumbnail"
                                                 style="max-width: 80px; max-height: 80px;">
                                        @else
                                            <img src="{{ asset('images/placeholder.jpg') }}"
                                                 alt="Placeholder"
                                                 class="img-thumbnail"
                                                 style="max-width: 80px; max-height: 80px;">
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $donation->formatted_date }}</td>
                                <td>{{ $donation->user->name }}</td>
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
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.donations.show', $donation) }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Supprimer" onclick="confirmDelete({{ $donation->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
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
            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-arrow-left me-2"></i>Retour au tableau de bord
            </a>
        </div>
    </div>

    <script>
        function confirmDelete(donationId) {
            if (confirm('Voulez-vous vraiment supprimer ce don ?')) {
                // Create and submit form for deletion
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/admin/donations/' + donationId;
                form.style.display = 'none';

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';

                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endsection