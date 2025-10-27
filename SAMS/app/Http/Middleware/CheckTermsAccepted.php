<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckTermsAccepted
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // Skip for guests or admins
        if (!$user || $user->isAdmin()) {
            return $next($request);
        }

        // If student hasn't accepted yet
        if (!$user->terms_accepted && !$request->is('terms*')) {
            return redirect()->route('terms.show');
        }

        return $next($request);
    }
}

