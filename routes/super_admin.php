<?php
use App\Http\Controllers\Admin\admintController;
use App\Http\Controllers\Front_End\admin_super\Operations\Collogecontroller;
use App\Http\Controllers\Front_End\admin_super\Operations\departcontroller;
use App\Http\Controllers\Front_End\admin_super\Operations\uni_departcontroller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\auth\superadmin_adminController;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\AdminMiddleware;
use App\Mail\RequestStatusMail;

use App\bootstrap\app;
use \App\Http\Controllers\Front_End\admin_teacher\Operations\ProjectController;
use App\Http\Controllers\Data\admin\show_Temp_projectController;
use App\Http\Controllers\Front_End\admin_dean\Operations\DeenprojectController;
use App\Http\Controllers\Front_End\admin_dean\Operations\TeamManagementController;
use App\Http\Controllers\Front_End\admin_super\pags\All_UniversityController;
use App\Http\Controllers\Front_End\admin_super\Operations\UniversityController;
use Illuminate\Support\Facades\Auth;




Route::get('/admin/login', [superadmin_adminController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [superadmin_adminController::class, 'login'])->name('admin.login');
// Route::post('/admin/logout', [superadmin_adminController::class, 'logout'])->name('logout');
Route::post('admin/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('admin.logout');







// Route::post('/logout', function () {
//     Auth::logout(); // خروج من الجلسة الافتراضية
//     Auth::guard('students')->logout(); // خروج من حارس الطلاب إن وجد
//     Auth::guard('admin_univer')->logout(); // خروج من حارس المشرفين إن وجد
//     Auth::logout();

//     request()->session()->invalidate();
//     request()->session()->regenerateToken();
//     return redirect()->route('login_student');
//     // return response()->json(['message' => 'logged out']);
// })->name('custom.logout');



Route::prefix('admin')->middleware(['AdminMiddleware:admin','verified'])->group(function () {
// Route::middleware(['auth','role:admin'])->group(function () {

    Route::get('dashboard', function () {
        return view ('home') ;
    })->name('admin.dashboard');


        Route::post('/temp-research', [show_Temp_projectController::class, 'store']);
        Route::post('/admin/research/approve/{id}', [show_Temp_projectController::class, 'approveResearch']);
        Route::post('/admin/research/reject/{id}', [show_Temp_projectController::class, 'rejectResearch']);
        Route::post('/research/approve/{id}', [show_Temp_projectController::class, 'approve'])->name('research.approve');
        Route::post('/research/reject/{id}', [show_Temp_projectController::class, 'reject'])->name('research.reject');




});






Route::prefix('superadmin')->middleware(['AdminMiddleware:superadmin'])->group(function () {
    // Route::middleware(['auth','role:admin'])->group(function () {


    Route::get('superadmin', function () {
        return view ('home') ;
    })->name('superadmin.dashboard');

    Route::resource('universities', UniversityController::class);
    // Route::put('/superadmin/universities/{id}', [UniversityController::class,'update'])->name('universities.update');

    // Route::resource('colloges', collogeController::class);
    // Route::resource('departs', departcontroller::class);
    // Route::resource('uni_coll', uni_departController::class);

});

Route::resource('universities', UniversityController::class);
Route::resource('colloges', Collogecontroller::class);
Route::resource('departs', departcontroller::class);
Route::resource('uni_departs', uni_departcontroller::class);




Route::prefix('teacher')->middleware(['checkadmin:teacher'])->group(function () {

    Route::get('/teacher', function () {
        return view ('home') ;
    })->name('teacher.dashboard');


    Route::get('/projects', [ProjectController::class, 'index'])->name('show_student_project_admin');

    Route::post('/projects/accept', [ProjectController::class, 'accept'])->name('projects.accept');
    Route::post('/projects/reject', [ProjectController::class, 'reject'])->name('projects.reject');
    Route::post('/projects/revert', [ProjectController::class, 'revert'])->name('projects.revert');










});
Route::get('admin/manage-teams', [TeamManagementController::class, 'index'])->name('dean.manage.teams');

Route::prefix('dean')->middleware(['checkadmin:dean'])->group(function () {



    Route::get('/Dean', function () {
        return view ('home') ;
    })->name('dean.dashboard');





    Route::get('/team-management', [TeamManagementController::class, 'index'])->name('team.management');
    Route::get('/team/search', [TeamManagementController::class, 'search']);
    Route::post('/team/update-topic', [TeamManagementController::class, 'updateTopic']);
    Route::post('/team/delete-member', [TeamManagementController::class, 'deleteMember']);
    Route::post('/team/add-member', [TeamManagementController::class, 'addMember']);
    Route::post('/team/update-supervisor', [TeamManagementController::class, 'updateSupervisor']);
    Route::post('/team/update-supervisor', [TeamManagementController::class, 'updateSupervisor']);




    Route::get('/projects', [DeenprojectController::class, 'index'])->name('show_student');
    Route::post('/projects/accept', [DeenprojectController::class, 'accept'])->name('projects.accept');
    Route::post('/projects/reject', [DeenprojectController::class, 'reject'])->name('projects.reject');
    Route::post('/projects/revert', [DeenprojectController::class, 'revert'])->name('projects.revert');


});







