<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $currentRole = $request->user()?->role;
        $hasRequiredRole = $currentRole === $role;
        $isCoordinatorOverseeingAdmin = $currentRole === 'coordinator' && $role === 'admin';
        if (!$currentRole || (!$hasRequiredRole && !$isCoordinatorOverseeingAdmin)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        return $next($request);
    }
}
