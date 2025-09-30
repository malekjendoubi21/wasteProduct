<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user || !$user->isAdmin()) {
            // Redirect non-admin users to home page with error message
            return redirect()->route('home')->with('error', 'Accès refusé. Seuls les administrateurs peuvent accéder à cette section.');
        }

        return $next($request);
    }
}
