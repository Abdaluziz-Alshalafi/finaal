<?php
namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // عرض نموذج تسجيل الدخول
    // public function showLoginForm()
    // {
    //     return view('admin.auth.login');
    // }

    // // معالجة تسجيل الدخول
    // public function login(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     if (Auth::attempt($credentials)) {
    //         $request->session()->regenerate();

    //         $user = Auth::user();
    //         if ($user->role === 'admin') {
    //             return redirect('/admin');
    //         } elseif ($user->role === 'superadmin') {
    //             return redirect('/superadmin');
    //         }
    //         elseif ($user->role === 'student') {
    //             $studentData = $user->profile; // الوصول إلى بيانات student
    //         }
    //     }

    //     return back()->withErrors([
    //         'email' => 'The provided credentials do not match our records.',
    //     ]);
    // }

    // // تسجيل الخروج
    // public function logout(Request $request)
    // {
    //     Auth::logout();

    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return redirect()->route('login'); // إعادة التوجيه إذا كان المستخدم مسجلاً
    // }
}
