





        {{-- @auth

@if(auth()->user()->user_type === 'superadmin')

<!-- SuperAdmin content -->

@elseif(auth()->user()->user_type === 'admin')

<!-- Admin content -->

@endif

@endauth --}}





@php


    $student = Auth::guard('students')->user();
    $adminUniver = Auth::guard('admin_univer')->user();
    $default = Auth::user();
            @endphp

            {{-- @section('content') --}}

            @if($student)
            @include('content.students.static.navber')

            @elseif($default && $default->role == 'superadmin')
            @include('content.admin.admin_super.static.navber')

            @elseif($default && $default->role == 'admin')
            @include('content.admin.admin_user_ums.static.navber')

            @elseif($adminUniver && $adminUniver->role === 'dean')
            @include('content.admin.admin_dean.static.navber')

            @elseif($adminUniver && $adminUniver->role === 'teacher')
            @include('content.admin.admin_teacher.static.navber')

            @else
            @include('content.guest.static.navber')

            {{-- @include('content.guest.static.navber') --}}


@endif





<!-- 🌟 إضافة مؤشر تحميل عند تسجيل الخروج -->
<script>
    document.getElementById('logoutBtnAdmin')?.addEventListener('click', function(event) {
        event.preventDefault(); // منع السلوك الافتراضي للزر
        this.disabled = true;
        this.innerHTML = 'جاري تسجيل الخروج...';

        // إرسال النموذج
        this.closest('form').submit();
    });

    document.getElementById('logoutBtnStudent')?.addEventListener('click', function(event) {
        event.preventDefault(); // منع السلوك الافتراضي للزر
        this.disabled = true;
        this.innerHTML = 'جاري تسجيل الخروج...';

        // إرسال النموذج
        this.closest('form').submit();
    });
</script>








