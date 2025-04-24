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


        @php
        $admin = Auth::guard('admin_univer')->user();
        $collegeName = $admin->college->coll_name ?? 'غير معروف';
            $coll = Auth::guard('admin_univer')->user()->id_college;
        @endphp


        <h3>{{ Auth::guard('admin_univer')->user()->name }}</h3>
        <p> عميد  {{$collegeName}}  </p>
      </div>
    </div>

    <nav class="sidebar-nav">
      <ul>
        <li>
          <a href="dashboard.html"><i class="fas fa-th-large"></i> لوحة التحكم</a>
        </li>
        <li class="{{ Route::currentRouteName() == 'show_student' ? 'active' : '' }}">
            <a href="{{ route('show_student') }}">
            <i class="fas fa-plus-circle"></i>  مشاريع</a>

        </li>
        <li class="{{ Route::currentRouteName() == 'team.management' ? 'active' : '' }}">
            <a href="{{ route('team.management')}}"><i class="fas fa-upload"></i> رفع</a>
        </li>
        <li class="{{ Route::currentRouteName() == '' ? 'active' : '' }}">
            <a href="team-management.html"><i class="fas fa-users"></i> إدارة الفريق</a>
        </li>
        <li>
          <a href="notifications.html"><i class="fas fa-bell"></i> الإشعارات</a>
        </li>
      </ul>
    </nav>

    <div class="sidebar-footer">
      <button class="theme-toggle">
        <i class="fas fa-moon"></i> الوضع الليلي
      </button>
      {{-- <h6>مرحبًا، {{ auth()->user()->name }}</h6> --}}
      <form action="{{ route('admin.logout') }}" method="POST">
          @csrf
      <button class="logout-btn">
        <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
      </button>

    </form>
    </div>
  </aside>