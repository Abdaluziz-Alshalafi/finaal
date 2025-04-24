<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\University;
use Illuminate\Http\Request;
use App\Models\LoginLog;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class studentController extends Controller
{


        public function showLoginForm()
    {

         $universities = University::all();
                return view("auth.student.login", compact("universities"));
    }


// افضل جربه لقد كل شي جاهز

    //     $credentials = $request->only('id_student', 'password');

    // if (Auth::guard('student')->attempt($credentials)) {
    //     return redirect()->intended('student/dashboard');
    // }

    // return back()->withErrors(['id_student' => 'Invalid credentials']);


        // معالجة تسجيل الدخول

public function login(Request $request)
{
    $request->validate([
        'id' => 'required|exists:universities,id',
        'Academic_number' => 'required',
        'phone' => 'required',
    ]);

    // التحقق من الطالب
    $student = Student::where('Academic_number', $request->Academic_number)
                      ->where('phone', $request->phone)
                      ->where('id_university', $request->id)
                      ->first();


    if ($student) {
        // $request->session()->regenerate();
    //
        Auth::guard('students')->login($student);

        // ✅ تسجيل الدخول في جدول login_logs
        LoginLog::create([
            'user_id'    => $student->id,
            'name'       => $student->name,
            'role'       => 'student', // هنا نحدد الدور يدويًا
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'logged_in_at' => now(),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'redirect' => route('dashboard')
            ]);
        }
        return redirect()->intended(route('dashboard'));
    }
    if ($request->ajax()) {
        return response()->json([
            'success' => false,
            'message' => 'الرقم الأكاديمي أو كلمة المرور غير صحيحة'
        ], 422);
    }

    throw ValidationException::withMessages([
        'student_id' => 'الرقم الأكاديمي أو كلمة المرور غير صحيحة',
    ]);
}




        //     'id' => 'required|integer|exists:university,id', // تحقق من وجود الجامعة


    protected function authenticated(Request $request, $user)
    {
        // استرجاع الرابط المحفوظ وإعادة التوجيه إليه بعد تسجيل الدخول
        if (session()->has('intended_url')) {
            return redirect(session()->pull('intended_url'));
        }

        return redirect()->route('dashboard');
    }


        // تسجيل الخروج
        public function logout(Request $request)
        {
            Auth::guard('students')->logout(); // تسجيل خروج المستخدم
            $request->session()->invalidate(); // إبطال الجلسة
            $request->session()->regenerateToken(); // تجديد رمز الجلسة

            return redirect()->route('login_student'); // توجيه المستخدم إلى صفحة تسجيل الدخول
        }




        public function dashboard()
        {
            // التحقق إذا كان الطالب مسجل دخوله
    if (Auth::guard('students')->check()) {
        // هنا سيعرض البيانات الخاصة بالطالب إذا كان قد سجل دخوله
        $studentId = Auth::guard('students')->user();
        $team = Team::where('id_student', $studentId->id)->first();
        $acount = 0;
        $approvedCount = 0;
        $pendingCount = 0;
        $rejectedCount = 0;
        $teams = collect(); // مجموعة فارغة إذا ما عنده فريق

        if ($team) {
            $acount = $team->requests->count();
            $approvedCount = $team->requests()->where('status', 'approved')->count();
            $pendingCount = $team->requests()->where('status', 'pending')->count();
            $rejectedCount = $team->requests()->where('status', 'rejected')->count();

            $teams = DB::table('teams')
                ->join('students', 'teams.id_student', '=', 'students.id')
                ->join('topics', 'teams.id', '=', 'topics.team_id')
                ->where('students.id_university', $studentId->id_university)
                ->select('students.name as student_name', 'topics.sub1 as topic_title')
                ->get();
        }
        return view('home', compact(
            'teams',
            'acount',
            'approvedCount',
            'pendingCount',
            'rejectedCount'
        ));
    } else {
        // إذا لم يكن قد سجل دخوله سيتم توجيه المستخدم إلى الصفحة الرئيسية بدون بيانات
        return redirect('/')->with('message', 'يرجى تسجيل الدخول أولاً');
    }}

    }
