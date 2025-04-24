













<header class="hero-landing">
        <div class="container">
          <div class="hero-content">
            <h1 class="hero-title animate-fade-in">منصة المشاريع المتخرجة</h1>
            <p class="hero-description animate-fade-in">اكتشف مشاريع الطلاب المتميزة من مختلف التخصصات والجامعات. منصتنا تعرض أفضل المشاريع المتخرجة وتتيح لك البحث والتصفح بسهولة.</p>
            <div class="hero-buttons animate-slide-in">
              <a href="projects.html" class="btn btn-primary">استكشف المشاريع</a>
              <a href="about.html" class="btn btn-outline">تعرف علينا</a>
            </div>
          </div>

        </div>
      </header>

      <section class="stats-home">
        <div class="container">
            <h2 class="section-title animate-slide-in">إحصائيات مشروعك</h2>

            <div class="stats-container">

                <div class="stat-card animate-count">
                    <div class="stat-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stat-info">
                        <h3>المشاريع النشطة</h3>
                        <p class="stat-value" id="projects-count">1</p>
                        <p class="stat-desc">لديك مشروع نشط واحد قيد التنفيذ</p>
                    </div>
                </div>

                <div class="stat-card animate-count">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3>أعضاء الفريق</h3>
                        <p class="stat-value" id="team-count">{{ $acount ?? 0 }}</p>
                        <p class="stat-desc">
                            @if($acount > 0)
                                تعمل مع {{ $acount }} {{ $acount == 1 ? 'عضو' : 'أعضاء' }} في الفريق
                            @else
                                لا يوجد أعضاء في الفريق حالياً
                            @endif
                        </p>
                    </div>
                </div>

                <div class="stat-card animate-count">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-info animate-count">
                        <h3>الموافقات المعلقة</h3>
                        <p class="stat-value">{{ $pendingCount ?? 0 }}</p>
                        <p class="stat-desc">{{ $pendingCount ?? 0 }} عناصر في انتظار الموافقة</p>
                    </div>
                </div>

            </div>
        </div>
    </section>






        {{-- @if($teams->isEmpty())
        <div class="alert alert-warning">
            لا توجد بيانات متاحة لعرضها حالياً.
        </div>
    @else
 --}}




        {{-- @endif --}}

      <!-- قسم أفضل المشاريع -->
      <section class="featured-projects">
        <div class="container">
          <h2 class="section-title animate-slide-in">أفضل المشاريع المتخرجة</h2>
          <div class="projects-grid " id="featured-projects-container">
            @foreach($teams as $team)
          <div class="project-card">
        <div class="university-badge "></div>
            <img src="${project.image}" alt="{{ $team->student_name }}">
            <div class="project-content">
              <h3>{{ $team->student_name }}</h3>
              <p>{{ $team->student_name }}</p>
              <div>
                <span class="badge">{{ $team->student_name }}</span>
                <span class="badge">{{ $team->student_name }}</span>
              </div>
              <button class="btn btn-primary view-project" data-id="${project.id}">عرض التفاصيل</button>
            </div>
          </div>
            @endforeach
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





