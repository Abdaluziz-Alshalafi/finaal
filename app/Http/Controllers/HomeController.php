<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index(){

        // $user = [
        //     'name' => 'أحمد علي',
        //     'role' => 'admin',  // يمكنك تغيير هذا إلى 'student' أو 'teacher' حسب الحاجة
        // ];

        // // قائمة الصفحات المتاحة لهذا المستخدم
        // $pages = [
        //     ['name' => 'لوحة اasلتحكم', 'slug' => 'dashboard'],
        //     ['name' => 'إدارة الفريق', 'slug' => 'team-management'],
        // ];
// compact('user', 'pages')
        // تمرير البيانات إلى الـ View
        return view('home');

     }
}
