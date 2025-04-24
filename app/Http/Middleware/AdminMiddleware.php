<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
{
    if (!Auth::check()) {
        return redirect()->route('admin.login');
    }

    if (!in_array(Auth::user()->role, ['admin', 'superadmin'])) {
        abort(403, 'Unauthorized access');
    }

    if (Auth::guard('students')->check()) {
        Auth::guard('students')->logout();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
    }

return $next($request);

}
}
