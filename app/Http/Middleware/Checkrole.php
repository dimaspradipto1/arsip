<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Checkrole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $allowedRoles = [
            'admin',
            'tatausaha',
            'dosen',
            'dekan',
            'wakilDekan1',
            'wakilDekan2',
            'kaprodi',
            'sekprodi',
        ];

        $rolesToCheck = !empty($roles) ? $roles : $allowedRoles;

        if ($user->hasRole('admin') || $user->hasRole($rolesToCheck)) {
            return $next($request);
        }

        abort(403, 'Akses Tidak Diizinkan');
    }
}
