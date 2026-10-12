<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login')->with('error', 'U dient eerst in te loggen om toegang te krijgen.');
        }

        $user = $request->user();

        if ($role === 'admin' && ! $user->isAdmin()) {
            return redirect()->route('home')->with('error', 'Toegang geweigerd: U heeft geen beheerderrechten.');
        }

        if ($role === 'klant' && ! $user->isKlant() && ! $user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Toegang geweigerd.');
        }

        return $next($request);
    }
}
