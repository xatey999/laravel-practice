<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  Allowed role values (e.g. admin, supplier)
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user instanceof User) {
            return $this->forbidden();
        }

        if (! $this->hasAnyAllowedRole($user, $roles)) {
            return $this->forbidden();
        }

        return $next($request);
    }

    private function hasAnyAllowedRole(User $user, array $roles): bool
    {
        return in_array($user->role->value, $roles, true);
    }

    private function forbidden(): Response
    {
        abort(Response::HTTP_FORBIDDEN);
    }
}
