<?php
use App\Http\Controllers\Admin\admintController;
use App\Http\Controllers\Front_End\student\Notifications\NotificationsController;
use App\Http\Controllers\Front_End\student\pags\All_requestsController;
use Illuminate\Support\Facades\Route;
  use App\Http\Middleware\CheckAdmin;
  use App\Http\Middleware\StudentMiddleware;

use App\bootstrap\app;
use App\Http\Controllers\auth\studentController;
use App\Http\Controllers\Front_End\student\Add_projectController;
use App\Http\Controllers\Front_End\student\Notifications\AllNotificationsController;
use App\Http\Controllers\Front_End\student\temp_Add_projectController;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('home');
// });
// Routes لتسجيل الدخول
// Route::get('/login_student', [studentController::class, 'showLoginForm'])->name('login_student');
// Route::post('/login_student', [studentController::class, 'login']);
// Route::post('/logout_student', [studentController::class, 'logout'])->name('logout_student');

Route::get('student/login', [studentController::class, 'showLoginForm'])->name('login_student');
Route::post('student/login', [studentController::class, 'login'])->name('student.login');
// Route::post('/student', [studentController::class, 'logout'])->name('logout_student');

Route::post('student/logout', [studentController::class, 'logout'])->name('logout');



Route::post('/logout', function () {
    Auth::logout(); // خروج من الجلسة الافتراضية
    Auth::guard('students')->logout(); // خروج من حارس الطلاب إن وجد
    Auth::guard('admin_univer')->logout(); // خروج من حارس المشرفين إن وجد
    Auth::logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('home');
    // return response()->json(['message' => 'logged out']);
})->name('custom.logout');


// Route::middleware(['auth'])->group(function () {
//     Route::get('/student/dashboard', function () {
//         // لوحة تحكم الطالب
//         return view('student.dashboard');
//     })->name('student.dashboard');
// });





// Route::group(['Auth::guest(students))'], function () {
//     Route::get('/student/dashboard', [studentController::class, 'dashboard'])->name('dashboard');

//     Route::get('/student/create', function () {
//                 return view('content.student.Operations.pg_create_project');
//             })->name('show_create_student_project');


// });


// routes/web.php


Route::prefix('student')->middleware(['StudentMiddleware:students'])->group(function () {

Route::get('/', function () {
    if (Auth::guard('students')->check()) {
        return redirect()->route('student.dashboard');
    }

    return view('welcome'); // صفحة الزائر
});
    // Route::get('/requests/{id}/edit', [All_requestsController::class, 'edit'])->name('student.requests.edit');
    // Route::put('/requests/{id}', [All_requestsController::class, 'update'])->name('student.requests.update');
    // Route::delete('/requests/{id}', [All_requestsController::class, 'destroy'])->name('student.requests.destroy');


    // Route::get('/', function () {
    //     return view ('home') ;
    // })->name('student.dashboard');



    Route::get('/research', [All_requestsController::class, 'index'])->name('research.index');

    // إنشاء بحث جديد
    Route::post('/research', [All_requestsController::class, 'store'])->name('research.store');

    // عرض تفاصيل البحث
    Route::get('/research/{id}', [All_requestsController::class, 'show'])->name('research.show');

    // جلب بيانات البحث للتعديل
    Route::get('/research/{id}/edit', [All_requestsController::class, 'edit'])->name('research.edit');

    // تحديث بيانات البحث
    Route::put('/research/{id}', [All_requestsController::class, 'update'])->name('research.update');

    // حذف البحث
    Route::delete('/research/{id}', [All_requestsController::class, 'destroy'])->name('research.destroy');











    // Route::get('/dashboard', [studentController::class,'dashboard'])->name('dashboard');
    Route::get('/', [StudentController::class, 'dashboard'])->name('dashboard');

    // صفحة إنشاء المشروع
    Route::get('create', [temp_Add_projectController::class, 'show_create'])->name('show_create_student_project');
    // جلب المشرفين عبر Ajax
    // Route::get('/get-supervisors', [temp_Add_projectController::class, 'getSupervisors'])->name('get_supervisors');

    Route::post('/research/store', [temp_Add_projectController::class, 'store'])->name('research.store');
    // Route::post('/research/reload', [temp_Add_projectController::class, 'reload'])->name('research.reload');
    Route::post('/check-student', [temp_Add_projectController::class, 'checkStudent'])->name('check-student');
    Route::post('student-data', [temp_Add_projectController::class, 'getStudentData']);

    Route::get('/researcher/accept/{requestId}', [temp_Add_projectController::class, 'researcher_accepted'])->name('researcher.accepted');
    Route::get('/researcher/reject/{requestId}', [temp_Add_projectController::class, 'researcher_rejected'])->name('researcher.rejected');
    Route::get('/confirmation', function () {
        return view('confirmation');
    })->name('confirmation.page');


    Route::get('/requests', [AllNotificationsController::class, 'index'])->name('requests.index');
    Route::get('/requests/{id}/edit', [AllNotificationsController::class, 'update'])->name('requests.update');
    Route::delete('/requests/{id}', [AllNotificationsController::class, 'destroy'])->name('requests.delete');



    Route::get('/Notification', [NotificationsController::class, 'index'])->name('notifications.index');
        Route::post('/research/store2/{id}', [NotificationsController::class, 'update_request_status'])->name('updata.stsat');
        // Route::post('/update-status/{id}', [::class, 'update_request_status'])->name('updata.stsat');


    // Route::post('/update-request-status', [::class, 'updateStatus'])->name('update_request_status');

        //  Route::post('/', [NotificationsController::class, 'update_request_status'])->name('requests.update_request_status');

});


    // Route::get('/dashboard', [ studentController::class, 'dashboard'])->name('dashboard');
    // Route::get('', [temp_Add_projectController::class, 'show_create_student_project'])->name('show_create_student_project');
    // Route::post('/research/store',[temp_Add_projectController::class,'store'])->name('research.store');
    // Route::post('/research/reload', [temp_Add_projectController::class, 'reload'])->name('research.reload');
    // Route::post('/check-student', action: [temp_Add_projectController::class, 'checkStudent']);
    // Route::post('/student-data', [temp_Add_projectController::class, 'getStudentData']);




// Route::post('/student/logout', [studentController::class, 'logout'])
//     ->middleware('auth')
//     ->name('logout');










// Route::middleware(['auth'])->group(function () {
//     Route::get('/student/dashboard', function () {
//         return view ('layouts.student') ;
//     })->name('dashboard');
// });

// Route::middleware(['auth'])->group(function () {
//     Route::get('/student/dashboard', function () {
//         return 'Welcome student';
//     })->name('/student/dashboard');
// });

// Routes خاصة بـ admin
// Route::middleware(['auth'])->group(function () {
//     Route::get('/admin', function () {
//         return view ('admin.dashboard.dashboard') ;
//     });
// });
// // // Routes خاصة بـ superadmin
// Route::middleware(['auth'])->group(function () {
//     Route::get('/superadmin', function () {
//         return 'Welcome student';
//     });
// });
