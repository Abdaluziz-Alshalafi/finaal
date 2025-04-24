     <header class="top-header">
      <button class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
      </button>
      <h1>لوحة التحكم</h1>
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

    <div class="dashboard-content">
      <div class="welcome-banner">
        <div class="welcome-text">
            @php
        $admin = Auth::guard('admin_univer')->user();
          @endphp
          <h2>مرحباً بك، {{$admin->name;}}</h2>
          <p>مرحباً بك في لوحة تحكم إدارة مشاريع التخرج</p>
        </div>
        <a href="add-project.html" class="primary-btn">
          <i class="fas fa-plus"></i> إضافة مشروع جديد
        </a>
      </div>

      <div class="stats-container">
        <div class="stat-card">
          <div class="stat-icon">
            <i class="fas fa-book"></i>
          </div>
          <div class="stat-info">
            <h3>المشاريع النشطة</h3>
            <p class="stat-value">1</p>
            <p class="stat-desc">لديك مشروع نشط واحد قيد التنفيذ</p>
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-icon">
            <i class="fas fa-users"></i>
          </div>
          <div class="stat-info">
            <h3>أعضاء الفريق</h3>
            <p class="stat-value">4</p>
            <p class="stat-desc">تعمل مع 4 أعضاء في الفريق</p>
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-icon">
            <i class="fas fa-check-circle"></i>
          </div>
          <div class="stat-info">
            <h3>الموافقات المعلقة</h3>
            <p class="stat-value">2</p>
            <p class="stat-desc">2 عناصر في انتظار الموافقة</p>
          </div>
        </div>
      </div>

      <div class="activity-section">
        <div class="section-header">
          <h2>النشاط الأخير</h2>
          <button class="view-all-btn">عرض الكل</button>
        </div>

        <div class="activity-list">
          <div class="activity-item">
            <div class="activity-avatar">
              <span>أم</span>
            </div>
            <div class="activity-details">
              <h4>تم تحديث مشروع نظام إدارة المستشفيات</h4>
              <p>قام أحمد بتحديث وثائق المشروع وإضافة متطلبات جديدة</p>
              <span class="activity-time">منذ 2 ساعة</span>
            </div>
          </div>

          <div class="activity-item">
            <div class="activity-avatar">
              <span>سأ</span>
            </div>
            <div class="activity-details">
              <h4>انضم عضو جديد إلى الفريق</h4>
              <p>انضمت سارة أحمد إلى فريق مشروع نظام إدارة المستشفيات</p>
              <span class="activity-time">منذ 5 ساعات</span>
            </div>
          </div>

          <div class="activity-item">
            <div class="activity-avatar">
              <span>خم</span>
            </div>
            <div class="activity-details">
              <h4>تعليق جديد من المشرف</h4>
              <p>أضاف د. خالد المحمد تعليقًا على مقترح المشروع</p>
              <span class="activity-time">منذ يوم واحد</span>
            </div>
          </div>
        </div>
      </div>
    </div>

