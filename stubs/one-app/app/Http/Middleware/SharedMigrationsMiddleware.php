<?php

namespace App\Http\Middleware;

use Closure;
use Envor\Datastore\Contracts\HasDatastoreContext;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SharedMigrationsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $datastoreContext = app(HasDatastoreContext::class)->datastoreContext();

        if (! $datastoreContext) {
            return $next($request);
        }

        if (! cache()->has('datastore_migrated_'.$datastoreContext->id)) {
            $datastoreContext->datastore->database()->migratePath('database/migrations/shared')->migrate();
            cache()->put('datastore_migrated_shared'.$datastoreContext->id, true, now()->addHour());
        }

        return $next($request);
    }
}
