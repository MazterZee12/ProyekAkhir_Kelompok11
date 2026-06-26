<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePasswordChanged
{
    /**
     * Halaman yang tetap boleh diakses walau must_change_password masih true.
     */
    protected array $allowedRoutes = [
        'password.change',
        'password.change.post',
        'logout',
        'logout.session',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->must_change_password && ! $request->routeIs(...$this->allowedRoutes)) {
            return redirect()
                ->route('password.change')
                ->with('info', 'Kamu masih menggunakan password sementara. Silakan ganti dulu sebelum melanjutkan.');
        }

        return $next($request);
    }
}
