<?php

namespace App\Http\Middleware;

use App\Models\Team;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DomainMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $domain = $request->getHost();

        if(! auth()->check()) {
            return $next($request);
        }

        // if the domain is not registered to any teams in th database
        if (! Team::where('domain', $domain)->exists()) {
            return $next($request);
        }

        if ($request->user()->currentTeam->domain !== $domain) {
           if ($request->user()->currentTeam->domain) {
               return redirect($request->user()->currentTeam->url);
            }

            return redirect(config('app.url') . config('fortify.home'));
        }

        return $next($request);
    }
}
