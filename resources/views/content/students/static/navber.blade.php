
<style>

    </style>
@include('static.dilog.dilog')
<nav class="navbar">

     <div class="container" style="max-width: 1400px;">
    <p>    @switch(Route::currentRouteName())
        @case('dashboard')
            الرئيسية
            @break

        @case('show_create_student_project')
            إضافة مشروع
            @break

            @case('research.index')
            إدارة الفريق
            @break
            @case('requests.details')
             تفاصيل المشروع
            @break
            @case('file.upload')
            رفع مرفقات المشروع
            @break
        @case('notifications.index')
            الإشعارات
            @break

        @default
            صفحة غير معرفة
    </p>
    @endswitch
      <div class="logo">
        <img src="https://placehold.co/40x40" alt="شعار المنصة">
        <span>منصة المشاريع</span>
      </div>

      <div class="nav-menu">
        <ul class="nav-links">
            <li>
                <a href="{{ route('dashboard') }}" class="{{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> رئيسية
                </a>
            </li>

            <li>
                <a href="{{ route('show_create_student_project') }}" class="{{ Route::currentRouteName() == 'show_create_student_project' ? 'active' : '' }}">
                    <i class="fas fa-plus-circle"></i> إضافة مشروع
                </a>
            </li>

            {{-- <li>
                <a href="{{ route('file.upload') }}" class="{{ Route::currentRouteName() == 'file.upload' ? 'active' : '' }}">
                    <i class="fas fa-upload"></i> رفع الملفات
                </a>
            </li> --}}

            <li>
                <a href="{{ route('research.index') }}" class="{{ Route::currentRouteName() == 'research.index' ? 'active' : '' }}">
                    <i class="fas fa-users"></i> إدارة الفريق
                </a>
            </li>

            <li style="display: none;">
                <a   class="{{ Route::currentRouteName() == 'requests.details' ? 'active' : '' }}">
                    <i class="fas fa-users"></i> تفاصيل البحث
                </a>
            </li>

            <li>
                <a href="{{ route('notifications.index') }}" class="{{ Route::currentRouteName() == 'notifications.index' ? 'active' : '' }}">
                    <i class="fas fa-bell"></i> الإشعارات
                </a>
            </li>
        <li>
            <a class="logout-btn " style="cursor: grab;">
                <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
            </a>
        </li>

                <li class=" btn btn-outline">طالب: {{ Auth::guard('students')->user()->name }}</li>


    </ul>


      </div>
<div class="theme-toggle">
                <button id="theme-toggle-btn">
                  <i class="fas fa-moon"></i>
                </button>
              </div>
      <div class="hamburger">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </nav>








