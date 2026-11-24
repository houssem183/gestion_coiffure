<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à l\'espace administration.');
        }

        if (!Auth::user()->isAdmin()) {
            return redirect()->route('user.dashboard')->with('error', 'Accès refusé ! Vous devez être administrateur pour accéder à cette page.');
        }

        return $next($request);
    }
}
