@extends('static.layouts.app')

    {{-- <script src="js/modernizr.js"></script>
    <script src="try/script.js"></script> --}}

    @section('title')
    admin
    @endsection



    @section('content')

<section class="auth-section">
    <div class="container"  style="width: 100%;padding:0%">
      <div class="auth-container">
        <div class="auth-card">
          <h1>تسجيل الدخول</h1>
          <p class="auth-description">أدخل بياناتك لتسجيل الدخول الى البوابةالالكترونية</p>

          <div class="user-type-selector">
            <div class="user-type-option active" data-type="student">
              <i class="fas  fa-chalkboard-teacher"></i>
              <span>مشرف</span>
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

{{-- wire:submit.prevent="loginUser" --}}
        <form id="loginForm" action="{{ route('admin.login') }}" method="POST">
            @csrf



                    <h2>دخول المشرف | Admin Login</h2>
                    {{-- <select name="role" required>
                        <option value="admin">Admin</option>
                        <option value="superadmin">SuperAdmin</option>
                    </select> --}}



                    <div class="form-group">
                        <label for="role">الجامعة</label>
                        <select  name="role" required>
                           <option value="" disabled selected> نوع المستخدم</option>
                          <option value="مدير المركز">مدير المركز</option>
                          <option value="مستخدم الجامعه">مستخدم الجامعه</option>
                          <option value="عميد الكليه">عميد الكليه</option>
                          <option value="مشرف">مشرف</option>
                        </select>

                          @error('id')
                          <span class="text-danger">{{$message}}</span>
                          @enderror
                      </div>

                      <div class="form-group">
                        <label for="name">الرقم الجامعي</label>
                        <input type="text" id="name" name="name" placeholder="أدخل اسم المستخدم" required>
                          @error('name')
                          <span class="text-danger">{{$message}}</span>
                          @enderror
                      </div>



                      <small class="form-hint">سيتم التحقق من وجود الرقم الجامعي في قاعدة البيانات</small>


                      <div class="form-group">
                        <label for="password">كلمة المرور</label>
                        <div class="password-input">
                          <input type="password" id="password" name="password" placeholder="أدخل كلمة المرور" required>
                          <button type="button" class="toggle-password">
                            <i class="fas fa-eye"></i>
                          </button>
                        </div>
                      </div>


                      <div class="form-message" id="student-form-message"></div>

                      <button type="submit" class="btn btn-primary btn-block">تسجيل الدخول </button>

            </form>

        </div>
    </div>
  </div>
</section>


             {{-- </form> --}}


        <!-- Admin Login Form -->


        <!-- Student Dashboard -->


    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}


    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');

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

                fetch('{{ route("admin.login") }}', {
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
                            text: data.message || ' اسم المستخدم أو كلمة المرور غير صحيحة',
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


@endsection
