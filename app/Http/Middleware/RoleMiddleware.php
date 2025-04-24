<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // تأكد من استيراد الكلاس Auth

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // التحقق مما إذا كان المستخدم قد قام بتسجيل الدخول
        // if (Auth::check() && Auth::user()->role === $role) {
        //     return $next($request);
        // }
        // return redirect()->route('login');
        // أو أي صفحة أخرى تريد توجيه المستخدم إليها



    //     if (Auth::guard('students')->check()) {
    //         $user = Auth::guard('students')->user();
    //     }

    //         // التحقق مما إذا كان المستخدم لديه الدور admin أو superadmin
    //         if (Auth::check() && Auth::user()->role === $role) {
    //             return $next($request);
    //         }


    //     // إعادة توجيه المستخدم إذا لم يكن لديه الأذونات اللازمة
    //     return redirect()->route('login'); // يمكنك تعديل هذا لتوجيه إلى صفحة أخرى إذا رغبت
    }

}
