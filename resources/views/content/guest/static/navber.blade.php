<nav class="navbar">
    <div class="container">
      <div class="logo">
        <img src="images (4).jpg?height=40&width=40" alt="شعار المنصة">
        <span>البوابة الالكترونية لمشاريع التخرج</span>
      </div>
      <div class="nav-menu">
        <ul class="nav-links">
            <li class=" active{{ request()->is('home') ? 'active' : '' }}">

          <a  href="{{ route('home') }}">الرئيسية</a></li>
          <li><a href="projects.html">المشاريع</a></li>
          <li><a href="about.html">من نحن</a></li>
          <li><a href="contact.html">اتصل بنا</a></li>
         <a href="{{ route('login_student') }}">
        <button class="login-btn">
          <i class="fas fa-login-in-alt"></i> تسجيل دخول الطلاب
        </button>
      </a>
      <div class="user-info">
        <h3>مرحبًا! زائر</h3>
       </div></ul>


       </div>

      <div class="hamburger">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </nav>