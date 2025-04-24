@vite([

    'resources/css/dilog.css',
])
<div class="dialog-overlay" id="logoutDialog">
    <div class="dialog warning">
      <div class="dialog-header">
        <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
        <button class="close-dialog">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="dialog-content">
        <p>هل أنت متأكد من رغبتك في تسجيل الخروج من النظام؟</p>
      </div>
      <div class="dialog-footer">
        <button class="secondary-btn">إلغاء</button>
        <form action="{{ route('custom.logout') }}" method="POST">
            @csrf
        <button class="primary-btn">تسجيل الخروج</button>
    </form>
      </div>
    </div>
  </div>
