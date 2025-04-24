



{{-- @if(Auth::guard('students')->check())

{{ route('dashboard') }}
 @include('content.students.pags.index')
@else --}}


<header class="hero-landing">
    <div class="container">
      <div class="hero-content">
        <h1 class="hero-title animate-fade-in">البوابة الالكترونية لمشاريع التخرج</h1>
        <p class="hero-description animate-fade-in">اكتشف مشاريع الطلاب المتميزة من مختلف التخصصات والجامعات. منصتنا تعرض أفضل المشاريع المتخرجة وتتيح لك البحث والتصفح بسهولة.</p>
        <div class="hero-buttons animate-slide-in">
          <a href="projects.html" class="btn btn-primary">استكشف المشاريع</a>
          <a href="about.html" class="btn btn-outline">تعرف علينا</a>
        </div>
      </div>
      <div class="hero-image animate-slide-in animate-3d">
        <img src="images (4).jpg?height=500&width=600" alt="شعار البوابة الالكترونية">
      </div>
    </div>
  </header>

  <!-- قسم أفضل المشاريع -->
  <section class="featured-projects">
    <div class="container">
      <h2 class="section-title animate-slide-in">أفضل المشاريع المتخرجة</h2>
      <div class="projects-grid" id="featured-projects-container">
        <!-- سيتم إضافة المشاريع المميزة هنا بواسطة JavaScript -->
      </div>
      <div class="view-all-container animate-fade-in">
        <a href="projects.html" class="btn btn-secondary">عرض جميع المشاريع</a>
      </div>
    </div>
  </section>

  <!-- قسم الإحصائيات -->
  <section class="stats-home">
    <div class="container">
      <h2 class="section-title animate-slide-in">إحصائيات المنصة</h2>
      <div class="stats-container">
        <div class="stat-card animate-count">
          <i class="fas fa-university animate-float"></i>
          <h3 id="universities-count">0</h3>
          <p>جامعة مشاركة</p>
        </div>
        <div class="stat-card animate-count">
          <i class="fas fa-project-diagram animate-float"></i>
          <h3 id="projects-count">0</h3>
          <p>مشروع متخرج</p>
        </div>
        <div class="stat-card animate-count">
          <i class="fas fa-graduation-cap animate-float"></i>
          <h3 id="majors-count">0</h3>
          <p>تخصص أكاديمي</p>
        </div>
        <div class="stat-card animate-count">
          <i class="fas fa-users animate-float"></i>
          <h3 id="students-count">0</h3>
          <p>طالب مشارك</p>
        </div>
      </div>
    </div>
  </section>

  <!-- نافذة تفاصيل المشروع -->
  <div class="modal" id="project-modal">
    <div class="modal-content">
      <span class="close-modal">&times;</span>
      <div class="modal-body" id="modal-content">
        <!-- سيتم إضافة تفاصيل المشروع هنا بواسطة JavaScript -->
      </div>
    </div>
  </div>
