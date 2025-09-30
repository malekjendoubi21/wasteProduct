<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ClientMiddleware
{
    public function handle($request, Closure $next)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user || !$user->isClient()) {
            abort(403, 'Accès refusé');
        }

        return $next($request);
    }
}

