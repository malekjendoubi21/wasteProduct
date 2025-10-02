<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = DatabaseNotification::where('notifiable_type', get_class($user))
            ->where('notifiable_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(15);
        return view('FrontOffice.notifications.index', compact('notifications'));
    }

    public function show(string $id)
    {
        $user = Auth::user();
        $notification = DatabaseNotification::where('id', $id)
            ->where('notifiable_type', get_class($user))
            ->where('notifiable_id', $user->id)
            ->firstOrFail();
        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }
        $data = $notification->data ?? [];
        if (!empty($data['commande_id'])) {
            return redirect()->route('front.orders.show', $data['commande_id']);
        }
        return redirect()->route('notifications.index');
    }
}
