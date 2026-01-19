<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Si no estás logueado O tu rol no es 'admin', prohibido el paso (Error 403)
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'ACCESO DENEGADO: Solo los administradores pueden realizar esta acción.');
        }

        return $next($request);
    }
}