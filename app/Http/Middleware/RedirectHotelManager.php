<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectHotelManager
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return $next($request);
        }

        if (auth()->user()->hasRole('Hotel Manager')) {

            // ✅ Ne jamais intercepter les requêtes Livewire (AJAX/wire)
            if ($request->hasHeader('X-Livewire')) {
                return $next($request);
            }

            $allowed = [
                'manager.*',
                'login',
                'logout',
                'password.*',
                'verification.*',
                'profile',
                'client-registration',
                'client-registration.download',
                'form-stepper',
            ];

            foreach ($allowed as $pattern) {
                if ($request->routeIs($pattern)) {
                    return $next($request);
                }
            }

            return redirect()->route('manager.dashboard');
        }

        return $next($request);
    }
}