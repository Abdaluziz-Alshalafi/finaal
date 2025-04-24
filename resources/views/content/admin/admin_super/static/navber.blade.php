
@include('static.dilog.dilog')

<main class="main-content">
<header class="top-header">
    <button class="menu-toggle" id="menuToggle">
      <i class="fas fa-bars"></i>
    </button>
    <h1>    @switch(Route::currentRouteName())
      @case('admin.dashboard')
          الرئيسية
          @break

      @case('universities.index')
      إدارة الجامعات
          @break

          @case('uni_departs.index')
          ربط الجامعات مع التخصصات
          @break
          @case('departs.index')
          إدارة التخصصات
          @break
          @case('colloges.index')
          إدارة الكليات          @break
      @case('notifications.index')
      إدارة الكليات
          @break

      @default
          صفحة غير معرفة

  @endswitch
</h1>


    <div class="header-actions">
      <button class="theme-toggle">
        <i class="fas fa-moon"></i>
      </button>
      <div class="notification-icon">
        <i class="fas fa-bell"></i>
        <span class="badge">3</span>
      </div>
    </div>
  </header>
</main>
<aside class="sidebar">
    <div class="sidebar-header">
      <div class="logo-container">
        <div class="logo">
          <span>GP</span>
        </div>
        <h2 class="logo-text">مشاريع التخرج</h2>
      </div>
      <button class="close-sidebar-btn" id="closeSidebar">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <div class="user-profile">
      <div class="avatar">
        <span>أم</span>
      </div>

      <div class="user-info">
        <h3>{{ auth()->user()->name }}</h3>
        <p>مدير مركز </p>
      </div>
    </div>

    <nav class="sidebar-nav">
      <ul>
        <li class="{{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-th-large"></i> الرئيسية</a>
        </li>
        <li class="{{ Route::currentRouteName() == 'universities.index' ? 'active' : '' }}">
           <a href="{{ route('universities.index') }}" >
            <i class="fas fa-users"></i> إدارة الجامعات</a>

        </li>

        <li class="{{ Route::currentRouteName() == 'colloges.index' ? 'active' : '' }}">
            <a href="{{route('colloges.index')}}"><i class="fas fa-bell"></i> إدارة الكليات</a>
        </li>
        <li class="{{ Route::currentRouteName() == 'departs.index' ? 'active' : '' }}">
            <a href="{{route('departs.index')}}"><i class="fas fa-upload"></i>  إدارة التخصصات</a>
        </li>

        <li class="{{ Route::currentRouteName() == 'uni_departs.index' ? 'active' : '' }}">
              <a href="{{ route('uni_departs.index') }}">
            <i class="fas fa-plus-circle"></i>  ربط الجامعات مع التخصصات</a>

        </li>




      </ul>
    </nav>

    <div class="sidebar-footer">
      <button class="theme-toggle">
        <i class="fas fa-moon"></i> الوضع الليلي
      </button>
      <h6>مرحبًا، {{ auth()->user()->name }}</h6>
      {{-- <form action="{{ route('admin.logout') }}" method="POST">
          @csrf --}}
      <button class="logout-btn">
        <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
      </button>
    {{-- </form> --}}
    </div>
  </aside>