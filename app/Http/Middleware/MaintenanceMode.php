<?php

namespace App\Http\Middleware;

use App\Models\SalonSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Bloque l'accès aux clients et aux visiteurs lorsque le mode maintenance est activé.
 * Les administrateurs et l'ensemble de l'espace d'administration (/admin/*) sont TOUJOURS autorisés.
 */
class MaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Les administrateurs connectés ont un accès total et ne sont JAMAIS bloqués
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $next($request);
        }

        // 2. Toutes les routes du panneau administration (/admin/*) sont strictement exemptées
        if ($request->is('admin*')) {
            return $next($request);
        }

        // 3. Les routes d'authentification (login, logout) restent toujours accessibles pour permettre la connexion admin
        if ($request->is('login*') || $request->is('logout*') || in_array($request->route()?->getName(), ['login', 'login.post', 'logout'])) {
            return $next($request);
        }

        try {
            $settings = SalonSetting::current();

            // 4. Si la maintenance est activée, bloquer les clients et visiteurs publics
            if ($settings->mode_maintenance) {
                $message = $settings->message_maintenance
                    ?: 'Notre salon est temporairement fermé pour maintenance. Merci de revenir bientôt !';

                return response()->view('maintenance', compact('message', 'settings'), 503);
            }
        } catch (\Throwable $e) {
            // Continuer en cas d'indisponibilité momentanée de la base
        }

        return $next($request);
    }
}
