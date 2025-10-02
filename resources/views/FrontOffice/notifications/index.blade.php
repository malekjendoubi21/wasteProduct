@extends('layouts.app')

@section('title', ' - Notifications')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Notifications</h1>
        <form method="POST" action="{{ route('notifications.readAll') }}">
            @csrf
            <button type="submit" class="btn btn-outline-secondary">
                <i class="fas fa-check"></i> Marquer tout comme lu
            </button>
        </form>
    </div>

    <div class="card">
        <div class="list-group list-group-flush">
            @forelse($notifications as $n)
                <a href="{{ route('notifications.show', $n->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-truck"></i>
                        <span class="ms-2">{{ $n->data['message'] ?? 'Notification' }}</span>
                        @if(!empty($n->data['statut']))
                            <span class="badge bg-info ms-2">{{ $n->data['statut'] }}</span>
                        @endif
                        <div class="small text-muted">{{ $n->created_at->format('Y-m-d H:i') }}</div>
                    </div>
                    @if(is_null($n->read_at))
                        <span class="badge bg-danger">Nouveau</span>
                    @endif
                </a>
            @empty
                <div class="list-group-item text-center text-muted">Aucune notification</div>
            @endforelse
        </div>
        @if($notifications->hasPages())
            <div class="card-footer">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
