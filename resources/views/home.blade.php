

    {{-- <x-layout randomvar="Home"> --}}

         @section('title')
        Home
        @endsection
        @include('static.dilog.dilog')
        {{-- @section('text')

        Hiiiiiii
        @endsection --}}
        @php
    $layout = 'static.layouts.student'; // القيمة الافتراضية

    if (Auth::guard('students')->check()) {
        $layout = 'static.layouts.student';

    } elseif (Auth::check() && Auth::user()->role == 'superadmin') {
        $layout = 'static.layouts.admin';

    } elseif (Auth::check() && Auth::user()->role == 'admin') {
        $layout = 'static.layouts.admin';

    } elseif (Auth::guard('admin_univer')->check()) {
        $role = Auth::guard('admin_univer')->user()->role;

        if ($role === 'dean' || $role === 'teacher') {
            $layout = 'static.layouts.admin';
        }
    }
@endphp

@extends($layout)

@section('content')
    @if(Auth::guard('students')->check())
         @include('content.students.pags.index')
        @vite([
            'resources/js/cheack.js',

    ])


    @elseif(Auth::check() && Auth::user()->role == 'superadmin')

        @include('content.admin.admin_super.pags.index')


    @elseif(Auth::check() && Auth::user()->role == 'admin')
         @include('content.admin.admin_user_ums.pags.index')


    @elseif(Auth::guard('admin_univer')->check())
        @php $role = Auth::guard('admin_univer')->user()->role; @endphp

        @if($role === 'dean')
         @include('content.admin.admin_dean.pags.index')


        @elseif($role === 'teacher')
             @include('content.admin.admin_teacher.pags.index')

        @endif

    @else
    @include('content.guest.pags.index')


     @endif

        @endsection


        {{-- @extends($layout) --}}

