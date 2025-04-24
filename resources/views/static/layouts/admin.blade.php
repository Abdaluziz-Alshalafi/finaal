<!DOCTYPE html>
<html dir="rtl">

<head>
     <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Meta Information -->
    <meta name="keywords" content="مشاريع تخرج, طلاب الجامعة, منصة أكاديمية, أبحاث طلابية">
    <meta name="description" content="منصة إلكترونية تتيح للطلاب عرض مشاريع تخرجهم وتصفح مشاريع من جامعات وتخصصات مختلفة.">
    <meta name="author" content="775527735">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>{{ config('app.name', 'منصة مشاريع التخرج') }} - @yield('title', 'الرئيسية')</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/png">

    <!-- Styles -->
    {{-- <link rel="stylesheet" href="{{ asset('css/all_min.css') }}"> --}}
    {{-- <link href="{{ asset('css/sweetalert-rtl.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite([
        'resources/css/styles.css',
    ])

    @stack('styles')

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script> --}}
</head>

<body>

    @include('static.includes.animation')
    @include('static.includes.navbar')

    <main class="main-content">
        @yield('content')
    </main>

    {{-- @include('static.includes.footer') --}}

    @vite([
        'resources/js/dashboard.js',
    ])
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('script')

</body>
</html>
