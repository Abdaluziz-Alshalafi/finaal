<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('home');
// })->name('home');

Route::get('/', function () {
    if (Auth::guard('students')->check()) {

        // $count;
        return redirect('/student');
    } else {
        return app(HomeController::class)->index();
    }
})->name('home');



//

// Route::get('{slug}', function ($slug) {
//     // تحقق من صلاحية المستخدم هنا إذا أردت

//     // تحقق من وجود ملف View بنفس اسم الـ slug
//     if (view()->exists('pages.' . $slug)) {
//         return view('pages.' . $slug);
//     }

//     abort(404); // إذا ما لقى الصفحة
// })->name('dynamic.page');

require base_path('routes/students.php');
require base_path('routes/super_admin.php');
// require base_path('routes/data.php');

