<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
    use App\Models\LoginLog;

class superadmin_adminController extends Controller
{
    //

    public function showLoginForm()
    {
        return view('auth.admin.login');
    }

    // معالجة تسجيل الدخول

public function login(Request $request)
{
    $credentials = $request->only('name', 'password');
    $role = $request->input('role');

    // تسجيل دخول الطلاب والمشرفين مع إضافة تسجيل الدخول في جدول login_logs
    if ($role === 'مدير المركز' || $role === "مستخدم الجامعه") {

        // محاولة تسجيل الدخول للمستخدم
        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate(); // تجديد الجلسة

            $user = Auth::user(); // جلب بيانات المستخدم

            // التحقق من حالة المستخدم
            if ($user->role === 'admin' && $user->status == 0) {

                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'لست مخول للاستخدام'
                    ], 422);
                }
                return redirect()->back()->withErrors("");
            }

            elseif ($user->role === 'admin' && $user->status == 1) {
                // تسجيل الدخول في جدول login_logs
                 LoginLog::create([
                    'user_id'    => $user->id,
                    'name'       => $user->name,
                    'role'       => 'admin', // نوع المستخدم
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'logged_in_at' => now(),
                ]);
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'redirect' => route('admin/dashboard')
                    ]);
                }
                return redirect()->intended(route('admin/dashboard')); // التوجيه إلى لوحة التحكم
            } elseif ($user->role === 'superadmin') {

                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'redirect' => route('superadmin.dashboard')
                    ]);
                }
                return redirect()->intended(route('superadmin.dashboard'));
            }
             else {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'صلاحيات غير معروفة'
                    ], 422);
                }
                return redirect()->back()->withErrors(['name' => 'صلاحيات غير معروفة']);
            }
        }
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'بيانات الدخول غير صحيحة'
            ], 422);
        }
        return back()->withErrors(['name' => 'بيانات الدخول غير صحيحة.']);

    } elseif ($role === "عميد الكليه" || $role === "مشرف") {

        // تسجيل دخول المشرفين
        if (Auth::guard('admin_univer')->attempt($credentials, $request->has('remember'))) {
            // $request->session()->regenerate(); // تجديد الجلسة

            $user = Auth::guard('admin_univer')->user(); // جلب بيانات المشرف

            // التحقق من حالة المستخدم
            if ($user->role === 'teacher' && $user->status == 0) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'لست مخول للاستخدام'
                    ], 422);
                }
                return redirect()->back()->withErrors(['name' => 'لست مخول للاستخدام']);
            } elseif ($user->role === 'teacher' && $user->status == 1) {
                // تسجيل الدخول في جدول login_logs
                LoginLog::create([
                    'user_id'    => $user->id,
                    'name'       => $user->name,
                    'role'       => 'teacher', // نوع المستخدم
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'logged_in_at' => now(),
                ]);
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'redirect' => route('teacher.dashboard')
                    ]);
                }
                return redirect()->route('teacher.dashboard');
            } elseif ($user->role === 'dean' && $user->status == 0) {

                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'لست مخول للاستخدام'
                    ], 422);
                }
                return redirect()->back()->withErrors(['name' => 'لست مخول للاستخدام']);
            }
                elseif ($user->role === 'dean' && $user->status == 1) {

                 // تسجيل الدخول في جدول login_logs
                LoginLog::create([
                    'user_id'    => $user->id,
                    'name'       => $user->name,
                    'role'       => 'dean', // نوع المستخدم
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'logged_in_at' => now(),
                ]);
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'redirect' => route('dean.dashboard')
                    ]);
                }
                return redirect()->route('dean.dashboard');
            } else {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'ليس لديك صلاحية الوصول'
                    ], 422);
                }
                return back()->withErrors(['name' => 'ليس لديك صلاحية الوصول']);
            }
        }
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'بيانات الدخول غير صحيحة.'
            ], 422);
        }
        return back()->withErrors(['name' => 'بيانات الدخول غير صحيحة.']);
    }

    if ($request->ajax()) {
        return response()->json([
            'success' => false,
            'message' => 'اختر نوع الدور أولاً'
        ], 422);
    }
    return back()->withErrors(['role' => 'اختر نوع الدور أولاً']);
}



    // تسجيل الخروج
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login'); // إعادة التوجيه إذا كان المستخدم مسجلاً
    }



}
