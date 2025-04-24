
@extends('static.layouts.app')
{{-- @extends('static.layouts.student') --}}


    @section('title')
    تسجيل الدخول
    @endsection

<nav class="navbar header   disbl  navbar-expand-lg" id="navbarSupportedContent">
    <div class="containers">
        <a class="navbar-brand">بوابة مشاريع التخرج</a>
        <div class="hamburger">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>
</nav>

    @section('content')

    <section class="auth-section">
        <div class="container" style="width: 100%;padding:0%">
          <div class="auth-container">
            <div class="auth-card">
          <h1>تسجيل الدخول</h1>
          <p class="auth-description">أدخل بياناتك لتسجيل الدخول الى البوابةالالكترونية</p>

          <div class="user-type-selector">
            <div class="user-type-option active" data-type="student">
              <i class="fas fa-user-graduate"></i>
              <span>طالب</span>
            </div>
          </div>
                  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
          <!-- نموذج المستخدم العادي -->


          <!-- نموذج الطالب -->
        <!--  <form id="student-form" class="auth-form" >-->
		    <form id="login_student" method="POST" action="{{ route('student.login') }}">
			@csrf
            <div class="form-group">
              <label for="id_university">الجامعة</label>
              <select id="id" name="id" required>
                <option value="" disabled selected>اختر الجامعة</option>
					@foreach($universities as $university)
                        <option value="{{ $university->id}}">{{ $university->name }}</option>
                    @endforeach
              </select>

				@error('id_university')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
              <label for="Academic_number">الرقم الجامعي</label>
              <input type="number" id="Academic_number" name="Academic_number" placeholder="أدخل رقمك الجامعي" required>
				@error('Academic_number')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>



            <small class="form-hint">سيتم التحقق من وجود الرقم الجامعي في قاعدة البيانات</small>


            <div class="form-group">
              <label for="phone">كلمة المرور</label>
              <div class="password-input">
                <input type="password" id="phone" name="phone" placeholder="أدخل كلمة المرور" required>
                <button type="button" class="toggle-password">
                  <i class="fas fa-eye"></i>
                </button>
              </div>
            </div>

         <!--   <div class="form-options">
              <label class="checkbox-label">
                <input type="checkbox" name="terms" required>
                <span>أوافق على <a href="#">الشروط والأحكام</a></span>
              </label>
            </div>
			-->

            <div class="form-message" id="student-form-message"></div>

            <button type="submit" class="btn btn-primary btn-block">تسجيل الدخول </button>
          </form>


        </div>
      </div>
    </div>
  </section>

    {{-- <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script> --}}




@endsection


{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loginForm = document.getElementById('login_student');

        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // عرض تنبيه التحميل
            Swal.fire({
                title: 'جاري تسجيل الدخول',
                text: 'يرجى الانتظار...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },
                customClass: {
                    popup: 'rtl-alert',
                    title: 'rtl-title',
                    content: 'rtl-content',
                }
            });

            // إرسال بيانات النموذج باستخدام AJAX
            const formData = new FormData(loginForm);

            fetch('{{ route("student.login") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // عرض تنبيه النجاح
                    Swal.fire({
                        title: 'تم تسجيل الدخول بنجاح',
                        text: 'سيتم توجيهك إلى لوحة التحكم...',
                        icon: 'success',
                        timer: 1500,
                        timerProgressBar: true,
                        customClass: {
                            popup: 'rtl-alert',
                            title: 'rtl-title',
                            content: 'rtl-content',
                        }
                    }).then(() => {
                        window.location.href = data.redirect;
                    });
                } else {
                    // عرض تنبيه الخطأ
                    Swal.fire({
                        title: 'خطأ في تسجيل الدخول',
                        text: data.message || 'الرقم الأكاديمي أو كلمة المرور غير صحيحة',
                        icon: 'error',
                        confirmButtonText: 'حاول مرة أخرى',
                        customClass: {
                            popup: 'rtl-alert',
                            title: 'rtl-title',
                            content: 'rtl-content',
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'خطأ',
                    text: 'حدث خطأ أثناء محاولة تسجيل الدخول. يرجى المحاولة مرة أخرى.',
                    icon: 'error',
                    confirmButtonText: 'حسناً',
                    customClass: {
                        popup: 'rtl-alert',
                        title: 'rtl-title',
                        content: 'rtl-content',
                    }
                });
            });
        });
    });
</script>
@endpush
