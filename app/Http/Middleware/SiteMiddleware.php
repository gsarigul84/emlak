<?php

namespace App\Http\Middleware;

use App\Models\Ayarlar;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class SiteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
      if(!Session::has('dovizcinsi')){
        session(['dovizcinsi' => config('site.dovizcinsi')]);
      }
      View::share('ayarlar', Ayarlar::all()->keyBy('anahtar'));
      return $next($request);
    }
}
