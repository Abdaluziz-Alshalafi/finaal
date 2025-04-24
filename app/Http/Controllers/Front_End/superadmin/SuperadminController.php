<?php

namespace App\Http\Controllers\Front_End\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuperadminController extends Controller
{
    //
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {


    }

    public function logout()
    {

    }

}
