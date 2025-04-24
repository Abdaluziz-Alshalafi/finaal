

    {{-- <x-layout randomvar="Home"> --}}

        @extends('static.layouts.student')
        {{-- @extends('layouts.student') --}}

        @section('title')
        Create Project
        @endsection

        <style>

            /* إعداد عام للنموذج */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}

/* تنسيق النموذج */
form {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* تنسيق العناوين */
h2, h3 {
    color: #333;
}

/* تنسيق الحقول */
input[type="text"],
input[type="number"],
textarea,
select {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box; /* لضمان عدم تجاوز الحقول لعرض النموذج */
}

/* تنسيق زر */
button {
    background-color: #007bff;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}



/* تنسيق التنبيهات */
.alert {
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 5px;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
}

/* تنسيق الخطوات */

.step.active {
    display: block; /* إظهار الخطوة النشطة فقط */
}

.student {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.student input {
    margin-right: 10px; /* فصل الحقول عن بعضها */
}
            </style>

        {{-- @section('text')

        Hiiiiiii
        @endsection --}}
                                        {{-- <form class="project-form" onsubmit="handleProjectSubmit(event)" onsub> --}}


                                            @section('content')
                                            <section>
                                                <div class="multi-step-container">
                                                    <div class="form-header">
                                                        <h1>تقديم مشروع بحث جديد</h1>
                                                        <p>أكمل الخطوات التالية لتقديم مشروع البحث الخاص بك</p>
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

                                                    @if (session('success'))
                                                    <div class="alert alert-success" role="alert">
                                                        {{ __(session('success')) }}
                                                    </div>
                                                    @endif

                                                    <!-- شريط التقدم -->
                                                    <div class="progress-container">
                                                        <div class="progress-bar">
                                                            <div class="progress" id="progress"></div>

                                                            <div class="step-indicator active" data-step="1">
                                                                <div class="step-icon">1</div>
                                                                <div class="step-text">معلومات البحث</div>
                                                            </div>

                                                            <div class="step-indicator" data-step="2">
                                                                <div class="step-icon">2</div>
                                                                <div class="step-text">أعضاء الفريق</div>
                                                            </div>

                                                            <div class="step-indicator" data-step="3">
                                                                <div class="step-icon">3</div>
                                                                <div class="step-text">المشرفين</div>
                                                            </div>

                                                            <div class="step-indicator" data-step="4">
                                                                <div class="step-icon">4</div>
                                                                <div class="step-text">التأكيد</div>
                                                            </div>
                                                        </div>
                                                    </div>

                                            <div class="form-content">
            <form id="studentForm" action="{{ route('research.store') }}" method="POST">
                @csrf

                <!-- الخطوة الأولى: معلومات البحث -->
                <div id="researchStep" class="step active">
                    <h2>الخطوة 1: معلومات البحث</h2>
                    <div id="researchFields">
                        <div class="research-container">
                            <div class="container-header">
                                <h3 class="container-title">البحث 1</h3>
                            </div>
                            <div class="researchField">
                                <label for="research_name">اسم البحث:</label>
                                <input type="text" class="form-control" name="research_name[]" placeholder="عنوان المشروع" required>

                                 <label for="research_description">وصف البحث:</label>
                                <textarea class="form-control" placeholder="وصف المشروع" name="research_description[]" required rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="add-research">إضافة بحث آخر</button>
                    <button type="button" class="next">التالي</button>
                </div>

                <!-- الخطوة الثانية: أسماء الطلاب -->
                <div id="teamMembers" class="step" style="display:none;">
                    <h2>الخطوة 2: أعضاء الفريق</h2>
                    <div id="students">
                        <label>الطلاب:</label>
                        <div class="student">
                            <input type="number" placeholder="الرقم الأكاديمي"
                                   value="{{ Auth::guard('students')->user()->Academic_number }}"
                                   required name="students[0][id_academic]" class="id_academic" readonly>
                            <input type="text" name="students[0][name_student]" class="name_student"
                                   value="{{ Auth::guard('students')->user()->name }}"
                                   placeholder="اسم الطالب" required readonly>
                        </div>
                    </div>
                    <button type="button" id="add-student">إضافة طالب</button>
                    <button type="button" class="prev">السابق</button>
                    <button type="button" class="next">التالي</button>
                </div>

                <!-- الخطوة الثالثة: اختيار المشرفين -->
                <div id="supervisorsStep" class="step" style="display:none;">
                    <h2>الخطوة 3: اختيار المشرفين</h2>
                    <label for="name_admin">اختر المشرفين من جامعتك:</label>
                    <select class="input" name="name_admin[]" id="name_admin" multiple required>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                    @error('name_admin')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <button type="button" class="prev">السابق</button>
                    <button type="button" class="next">عرض البيانات</button>
                </div>

                <!-- الخطوة الرابعة: تأكيد البيانات -->
                <div id="confirmationStep" class="step" style="display:none;">
                    <h2>الخطوة 4: تأكيد البيانات</h2>
                    <div id="confirmationContent"></div>
                    <button type="button" class="prev">السابق</button>
                    <button type="submit" id="submitButton">رفع المشروع</button>
                </div>
            </form>

            <script>
            $(document).ready(function() {
                let studentIndex = 1; // عدد الطلاب
                const maxStudents = 5; // الحد الأقصى للطلاب
                let researchIndex = 1; // عدد حقول البحث
                const maxResearchFields = 3; // الحد الأقصى لحقول البحث
                let currentStep = 0; // تتبع الخطوة الحالية

                function showStep(step) {
                    $('.step').hide(); // إخفاء جميع الخطوات
                    $('.step').eq(step).show(); // إظهار الخطوة الحالية
                }

                // عرض الخطوة الأولى عند التحميل
                showStep(currentStep);

                // إضافة حقل بحث جديد
                $('#add-research').on('click', function() {
                    if (researchIndex < maxResearchFields) {
                        const researchDiv = `
                            <div class="researchField">
                                <label for="research_name">اسم البحث:</label>
                                <input type="text" name="research_name[]" placeholder="عنوان المشروع" required>
                                <label for="research_description">وصف البحث:</label>
                                <textarea placeholder="وصف المشروع" name="research_description[]" required rows="4" style="width: auto;"></textarea>
                                <button type="button" class="remove-research">إزالة</button>
                            </div>
                        `;
                        $('#researchFields').append(researchDiv);
                        researchIndex++;
                    } else {
                        alert('يمكنك إضافة 3 حقول بحث كحد أقصى.');
                    }
                });

                // إزالة حقل بحث
                $(document).on('click', '.remove-research', function() {
                    $(this).closest('.researchField').remove();
                    researchIndex--; // تقليل العداد
                });

                // إضافة طالب جديد
                $('#add-student').on('click', function() {
                    if (studentIndex < maxStudents) {
                        const studentDiv = `
                            <div class="student">
                                <input type="number" placeholder="الرقم الأكاديمي" required name="students[${studentIndex}][id_academic]" class="id_academic">
                                <input type="text" name="students[${studentIndex}][name_student]" class="name_student" placeholder="اسم الطالب" required readonly>
                                <button type="button" class="remove-student">إزالة</button>
                            </div>
                        `;
                        $('#students').append(studentDiv);
                        studentIndex++;
                    } else {
                        alert('يمكنك إضافة 5 طلاب كحد أقصى.');
                    }
                });

                // التحقق من الرقم الأكاديمي
                $(document).on('input', '.id_academic', function() {
                    const idAcademic = $(this).val(); // الحصول على قيمة الرقم الأكاديمي
                    const studentDiv = $(this).closest('.student'); // الحصول على div الطالب

                    if (idAcademic.length >= 10) { // تحقق من طول الرقم الأكاديمي
                        $.ajax({
                            url: '/student/check-student',
                            method: 'POST',
                            data: {
                                id_academic: idAcademic,
                                _token: '{{ csrf_token() }}' // إضافة رمز CSRF
                            },
                            success: function(response) {
                                if (response.exists) {
                                    // إذا كان الطالب موجودًا، استرجع بياناته
                                    $.ajax({
                                        url: 'student/student-data', // URL لطلب بيانات الطالب
                                        method: 'POST',
                                        data: {
                                            id_academic: idAcademic,
                                            _token: '{{ csrf_token() }}' // إضافة رمز CSRF
                                        },
                                        success: function(data) {
                                            studentDiv.find('.name_student').val(data.name); // تحديث حقل اسم الطالب
                                        }
                                    });
                                } else {
                                    studentDiv.find('.name_student').val(''); // إعادة تعيين حقل اسم الطالب
                                    alert('لا يوجد طالب بهذا الرقم الأكاديمي.'); // عرض رسالة خطأ
                                }
                            }
                        });
                    } else {
                        studentDiv.find('.name_student').val(''); // إعادة تعيين حقل اسم الطالب إذا كان المدخل أقل من 10 أرقام
                    }
                });

                // إزالة طالب
                $(document).on('click', '.remove-student', function() {
                    if (studentIndex > 1) {
                        studentIndex--; // تقليل العداد
                        $(this).closest('.student').remove();
                    } else {
                        alert('لا يمكن جعله بدون طلاب.');
                    }
                });

                // التحقق من المدخلات قبل الانتقال إلى الخطوة التالية
                function validateInputs(step) {
                    let valid = true;

                    if (step === 0) {
                        // الخطوة الأولى
                        $('#researchFields .researchField').each(function() {
                            const researchName = $(this).find('input[name="research_name[]"]').val();
                            const researchDescription = $(this).find('textarea[name="research_description[]"]').val();
                            if (!researchName || !researchDescription) {
                                valid = false;
                            }
                        });
                    } else if (step === 1) {
                        // الخطوة الثانية
                        $('#students .student').each(function() {
                            const studentId = $(this).find('.id_academic').val();
                            const studentName = $(this).find('.name_student').val();
                            if (!studentId || studentId.length < 10 || !studentName) {
                                valid = false;
                            }
                        });
                    } else if (step === 2) {
                        // الخطوة الثالثة
                        if ($('#name_admin option:selected').length === 0) {
                            valid = false;
                        }
                    }

                    return valid;
                }

                // تنقل بين الخطوات
                $('.next').on('click', function() {
                    if (validateInputs(currentStep)) {
                        if (currentStep === 2) {
                            // في الخطوة الثالثة، عرض البيانات
                            let confirmationHTML = '<h3>البيانات المدخلة:</h3>';

                            // إضافة معلومات البحث
                            $('#researchFields .researchField').each(function() {
                                const researchName = $(this).find('input[name="research_name[]"]').val();
                                const researchDescription = $(this).find('textarea[name="research_description[]"]').val();
                                confirmationHTML += `<p><strong>اسم البحث:</strong> ${researchName}<br><strong>وصف البحث:</strong> ${researchDescription}</p>`;
                            });

                            // إضافة أسماء الطلاب
                            $('#students .student').each(function() {
                                const studentId = $(this).find('.id_academic').val();
                                const studentName = $(this).find('.name_student').val();
                                confirmationHTML += `<p><strong>الطالب:</strong> ${studentName} (الرقم الأكاديمي: ${studentId})</p>`;
                            });

                            // إضافة أسماء المشرفين
                            const selectedSupervisors = $('#name_admin option:selected').map(function() {
                                return $(this).text();
                            }).get().join(', ');
                            confirmationHTML += `<p><strong>المشرفون:</strong> ${selectedSupervisors}</p>`;

                            // عرض البيانات المدخلة
                            $('#confirmationContent').html(confirmationHTML);
                            $('#confirmationStep').show();
                        }

                        currentStep++;
                        showStep(currentStep);
                    } else {
                        alert('يرجى ملء جميع المدخلات بشكل صحيح قبل الانتقال.');
                    }
                });

                $('.prev').on('click', function() {
                    currentStep--;
                    showStep(currentStep);
                });
            });
            </script>


{{-- <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script> --}}

     {{-- </x-layout> --}}

     @endsection



