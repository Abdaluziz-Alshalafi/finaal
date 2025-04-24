<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




// use Symfony\Component\HttpFoundation\Response;

class StudentMiddleware
{

    //  @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next

    public function handle(Request $request, Closure $next)
    {
    if (!Auth::guard('students')->check()) {
        return redirect()->intended(route('student.login'))->with('intended_url', $request->fullUrl());
    }

    // تسجيل خروج المدراء أو أي مستخدم غير الطالب
    if (Auth::check() || Auth::guard('admin_univer')->check()) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    return $next($request);
}
}