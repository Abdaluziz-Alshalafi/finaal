<!DOCTYPE html>
<html dir="rtl">


<head>
    <!-- Basic -->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'منصة مشاريع التخرج') }} - @yield('title', 'الرئيسية')</title>

     <!-- Font Awesome -->

     <!-- Styles -->
     {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
     {{-- <link href="{{ asset('css/sweetalert-rtl.css') }}" rel="stylesheet"> --}}

     <style>
        </style>
     @stack('styles')

    {{-- <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script> --}}
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"> --}}

{{--
 --}}
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <title>@yield('title')</title>
    @vite([
        // 'resources/css/app.css',
        'resources/css/stylesss.css',
        // 'resources/css/styles.css',
        'resources/css/add-projects.css',

        'resources/css/multi-step-form.css',
        // 'resources/css/her.css',

        // 'resources/js/add_project.js',


    ])
     {{-- <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script> --}}

     {{-- <script src="{{ vite('resources/site/js/jquery-3.6.0.min.js') }}"></script> --}}


</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


@include('static.includes.animation')

@include('static.includes.navbar')
<main class="main-content">
     @yield('content')
    </main>

{{-- @include('static.includes.footer') --}}
@vite([

        // 'resources/css/multi-step-form.css',
        // 'resources/css/her.css',


        'resources/js/app.js',
        'resources/js/dashboard.js',
            'resources/js/add_project.js',
            'resources/js/script.js',


    ])


<script>
    @if(Auth::guard('students')->check())
        window.currentUser = @json(Auth::guard('students')->user());
        window.userType = "{{ Auth::guard('students')->user()->getTable() }}";
        window.routes = {
        login: "{{ route('login_student') }}",
        logout: "{{ route('custom.logout') }}"
    };
    // @elseif(Auth::check() && Auth::user()->role == 'superadmin')

    @else
        window.currentUser = null;
        window.userType = null;
    @endif
</script>

@yield('script')

</body>

</html>
