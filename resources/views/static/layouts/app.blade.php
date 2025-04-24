<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'منصة مشاريع التخرج') }} - @yield('title', 'الرئيسية')</title>

    <!-- الخطوط -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->

    <!-- Styles -->


 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- <link href="{{ asset('css/sweetalert-rtl.css') }}" rel="stylesheet"> --}}

    <title>@yield('title')</title>
    @vite([
            'resources/css/styles.css',
        // 'resources/css/app.css',
        'resources/css/stylesss.css',

        // 'resources/css/multi-step-form.css',

        // 'resources/js/app.js',
        // 'resources/js/script.js',
        // 'resources/js/add_project.js',
    ])
    @stack('styles')
</head>
<body class="font-tajawal bg-gray-50">
    {{-- @auth
        @include('layouts.header')

        <div class="flex min-h-screen pt-16">
            @include('layouts.sidebar')

            <main class="flex-1 p-6 md:mr-64">
                @yield('content')
            </main>
        </div>
    @else
        <main>
            {{-- @yield('content') --}}



    @include('static.includes.animation')
    {{-- @include('static.includes.navbar') --}}

    <main class="main-content">
        @yield('content')
    </main>

    {{-- @include('static.includes.footer') --}}
    <!-- Scripts -->

    <!-- عرض رسائل SweetAlert2 من الجلسة -->
    @if (session('swal_success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: "{{ session('swal_success.title') }}",
                text: "{{ session('swal_success.text') }}",
                icon: "{{ session('swal_success.icon') }}",
                confirmButtonText: 'حسناً',
                customClass: {
                    popup: 'rtl-alert',
                    title: 'rtl-title',
                    content: 'rtl-content',
                }
            });
        });
    </script>
    @endif

    @if (session('swal_error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: "{{ session('swal_error.title') }}",
                text: "{{ session('swal_error.text') }}",
                icon: "{{ session('swal_error.icon') }}",
                confirmButtonText: 'حسناً',
                customClass: {
                    popup: 'rtl-alert',
                    title: 'rtl-title',
                    content: 'rtl-content',
                }
            });
        });
    </script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    @stack('scripts')
</body>
</html>
