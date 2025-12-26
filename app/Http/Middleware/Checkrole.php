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
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()->isAdmin || Auth::user()->isDosen || Auth::user()->isDekan || Auth::user()->isKaprodi || Auth::user()->isSekProdi || Auth::user()->isWakilDekan1 || Auth::user()->isWakilDekan2){

            return $next($request);
        }
        return $next($request);
    }
}
