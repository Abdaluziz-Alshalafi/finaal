

    {{-- <x-layout randomvar="Home"> --}}

        @extends('static.layouts.student')
        {{-- @extends('layouts.student') --}}

        @section('title')
        Create Project
        @endsection

        <!-- Bootstrap CSS -->
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> --}}


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
    background: var(--back-color);
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* تنسيق العناوين */
/* h2, h3 {
    color: #333;
} */

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
.progress-bar {
    flex-direction: row !important;
}

            </style>


        @section('content')


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
                                                    <div class="progress-container" style="flex-direction: row !important;">
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
                    <button type="button" id="add-research" class="btn btn-success">إضافة بحث آخر</button>
                    <button type="button" class="next btn btn-primary ">التالي</button>
                </div>

                <!-- الخطوة الثانية: أسماء الطلاب -->
                <div id="teamMembers" class="step bg-light p-5 rounded-4 shadow-sm border" style="display:none; direction: rtl;">
                    <h2 class="mb-4 text-dark-emphasis fw-bold fs-3 text-center border-bottom pb-2">
                        <i class="bi bi-people-fill text-primary me-2"></i> الخطوة 2: أعضاء الفريق
                    </h2>

                    <div id="students">
                        <div class="student border rounded-3 p-4 mb-3 bg-white shadow-sm">
                            <label class="form-label">الرقم الأكاديمي:</label>
                            <input type="number" placeholder="الرقم الأكاديمي"
                                   value="{{ Auth::guard('students')->user()->Academic_number }}"
                                   required name="students[0][id_academic]" class="form-control id_academic mb-3" readonly>

                            <label class="form-label">اسم الطالب:</label>
                            <input type="text" name="students[0][name_student]" class="form-control name_student"
                                   value="{{ Auth::guard('students')->user()->name }}"
                                   placeholder="اسم الطالب" required readonly>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" id="add-student" class="btn btn-outline-primary rounded-pill px-4">
                            <i class="bi bi-person-plus-fill me-1"></i> إضافة طالب
                        </button>

                        <div>
                            <button type="button" class="prev btn btn-outline-danger rounded-pill px-4 me-2">
                                <i class="bi bi-arrow-right-circle-fill me-1"></i> السابق
                            </button>

                            <button type="button" class="next btn btn-success rounded-pill px-4">
                                التالي <i class="bi bi-arrow-left-circle-fill ms-1"></i>
                            </button>
                        </div>
                    </div>
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
                    <button type="button" class="prev btn">السابق</button>
                    <button type="button" class="next btn">عرض البيانات</button>
                </div>

                <!-- الخطوة الرابعة: تأكيد البيانات -->
                <div id="confirmationStep" class="step" style="display:none;">
                    <h2>الخطوة 4: تأكيد البيانات</h2>
                    <div id="confirmationContent"></div>
                    <button type="button" class="prev btn">السابق</button>
                    <button type="submit" id="submitButton btn-success">رفع المشروع</button>
                </div>
            </form>

            {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

            <script>
                $(document).ready(function() {
                    function showAlert(text) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'تنبيه',
                            text: text,
                            confirmButtonText: 'حسنًا'
                        });
                    }

                    let studentIndex = 1;
                    const maxStudents = 5;
                    let researchIndex = 1;
                    let reIndex =researchIndex+ 1;

                    const maxResearchFields = 3;
                    let currentStep = 0;

                    function showStep(step) {
                        $('.step').hide();
                        $('.step').eq(step).show();
                    }

                    showStep(currentStep);

                    $('#add-research').on('click', function() {
                        if (researchIndex < maxResearchFields) {
                            const researchDiv = `
                                <div class="research-container">
                            <div class="container-header">
                                <h3 class="container-title">البحث ${reIndex++}</h3>
                            <button type="button" class="remove-research btn btn-danger">
    <i class="fas fa-trash-alt" style="color: red; "></i> <!-- تغيير لون الأيقونة إلى اللون الأبيض -->
</button></div>
                            <div class="researchField">
                                <label for="research_name">اسم البحث:</label>
                                <input type="text" class="form-control" name="research_name[]" placeholder="عنوان المشروع" required>

                                 <label for="research_description">وصف البحث:</label>
                                <textarea class="form-control" placeholder="وصف المشروع" name="research_description[]" required rows="4"></textarea>


                                </div>
                        </div>
                            `;
                            $('#researchFields').append(researchDiv);
                            researchIndex++;
                        } else {
                            showAlert('يمكنك إضافة 3 حقول بحث كحد أقصى.');
                        }
                    });

                    $(document).on('click', '.remove-research', function() {
                        $(this).closest('.research-container').remove();
                        researchIndex--;
                    });

                    $('#add-student').on('click', function() {
                        if (studentIndex < maxStudents) {
                            const studentDiv = `
                                <div class="student">
                                    <input type="number" placeholder="الرقم الأكاديمي" required name="students[${studentIndex}][id_academic]" class="id_academic">
                                    <input type="text" name="students[${studentIndex}][name_student]" class="name_student" placeholder="اسم الطالب" required readonly>
                                        <button type="button" class="remove-student btn btn-danger">
                                            <i class="fas fa-trash-alt"></i> <!-- أيقونة سلة المهملات -->
                                        </button>                                </div>
                            `;
                            $('#students').append(studentDiv);
                            studentIndex++;
                        } else {
                            showAlert('يمكنك إضافة 5 طلاب كحد أقصى.');
                        }
                    });

                    $(document).on('click', '.remove-student', function() {
                        if (studentIndex > 2) {
                            studentIndex--;
                            $(this).closest('.student').remove();
                        } else {
                            showAlert('يجب أن يكون هناك طالبين على الأقل.');
                        }
                    });

                    $(document).on('input', '.id_academic', function() {
    const idAcademic = $(this).val(); // الحصول على قيمة الرقم الأكاديمي
    const studentDiv = $(this).closest('.student'); // الحصول على div الطالب
    let duplicateId = false;

    if (idAcademic.length >= 10) { // تحقق من طول الرقم الأكاديمي
        // التحقق من الأرقام الأكاديمية الأخرى في النموذج باستثناء الرقم الحالي
        $('#students .student').each(function() {
            const studentId = $(this).find('.id_academic').val();
            if (idAcademic === studentId && idAcademic !== '') {
                if (studentDiv.find('.id_academic').val() !== studentId) {
                    duplicateId = true; // إذا كان الرقم مكررًا
                }
            }
        });

        if (duplicateId) {
            studentDiv.find('.id_academic').val(''); // مسح الرقم الأكاديمي المكرر
            showAlert('رقم الأكاديمي مكرر، لايمكن اختيار نفس الرقم  .'); // تنبيه
        } else {
            // إجراء البحث إذا كان الرقم الأكاديمي صحيحًا
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
                            url: '/student/student-data', // URL لطلب بيانات الطالب
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
                        showAlert(response.message);  // عرض رسالة الخطأ
                    }
                }
            });
        }
    } else {
        studentDiv.find('.name_student').val(''); // إعادة تعيين حقل اسم الطالب إذا كان المدخل أقل من 10 أرقام
    }
});


                    function validateInputs(step) {
                        let valid = true;

                        if (step === 0) {
                            const namesSet = new Set();
                            const descSet = new Set();
                            let duplicateName = false;
                            let duplicateDesc = false;

                            $('#researchFields .researchField').each(function () {
                                const researchName = $(this).find('input[name="research_name[]"]').val().trim();
                                const researchDescription = $(this).find('textarea[name="research_description[]"]').val().trim();

                                if (!researchName || !researchDescription) {
                                    valid = false;
                                    showAlert('يرجى تعبئة اسم ووصف كل بحث.');
                                    return false;
                                }

                                if (namesSet.has(researchName)) {
                                    duplicateName = true;
                                } else {
                                    namesSet.add(researchName);
                                }

                                if (descSet.has(researchDescription)) {
                                    duplicateDesc = true;
                                } else {
                                    descSet.add(researchDescription);
                                }
                            });

                            if (duplicateName) {
                                valid = false;
                                showAlert('يوجد تشابه في أسماء الأبحاث.');
                                return false;
                            }

                            if (duplicateDesc) {
                                valid = false;
                                showAlert('يوجد تشابه في أوصاف الأبحاث.');
                                return false;
                            }

                            // if ($('#researchFields .researchField').length < 2) {
                            //     valid = false;
                            //     showAlert('يجب إضافة بحثين على الأقل.');
                            //     return false;
                            // }
                        }

                        else if (step === 1) {
    if ($('#students .student').length < 2) {
        showAlert('يجب إدخال طالبين على الأقل.');
        return false;
    }

    const idSet = new Set();
    let duplicateId = false;

    $('#students .student').each(function() {
        const studentId = $(this).find('.id_academic').val();
        const studentName = $(this).find('.name_student').val();

        if (!studentId || studentId.length < 10 || !studentName) {
            valid = false;
            showAlert('يرجى إدخال رقم أكاديمي صحيح واسم الطالب.');
            return false;
        }

        if (idSet.has(studentId)) {
            duplicateId = true;
        } else {
            idSet.add(studentId);
        }
    });

    if (duplicateId) {

        valid = false;
        showAlert('يوجد تكرار في الأرقام الأكاديمية.');
        return false;
    }
}

                        else if (step === 2) {
                            if ($('#name_admin option:selected').length === 0) {
                                valid = false;
                                showAlert('يرجى اختيار مشرف واحد على الأقل.');
                                return false;
                            }
                        }

                        return valid;
                    }

                    $('.next').on('click', function() {
                        if (validateInputs(currentStep)) {
                            if (currentStep === 2) {
                                let confirmationHTML = '<h3>البيانات المدخلة:</h3>';

                                $('#researchFields .researchField').each(function() {
                                    const researchName = $(this).find('input[name="research_name[]"]').val();
                                    const researchDescription = $(this).find('textarea[name="research_description[]"]').val();
                                    confirmationHTML += `<p><strong>اسم البحث:</strong> ${researchName}<br><strong>وصف البحث:</strong> ${researchDescription}</p>`;
                                });

                                $('#students .student').each(function() {
                                    const studentId = $(this).find('.id_academic').val();
                                    const studentName = $(this).find('.name_student').val();
                                    confirmationHTML += `<p><strong>الطالب:</strong> ${studentName} (الرقم الأكاديمي: ${studentId})</p>`;
                                });

                                const selectedSupervisors = $('#name_admin option:selected').map(function() {
                                    return $(this).text();
                                }).get().join(', ');
                                confirmationHTML += `<p><strong>المشرفون:</strong> ${selectedSupervisors}</p>`;

                                $('#confirmationContent').html(confirmationHTML);
                                $('#confirmationStep').show();
                            }

                            currentStep++;
                            showStep(currentStep);
                        }
                    });

                    $('.prev').on('click', function() {
                        currentStep--;
                        showStep(currentStep);
                    });
                });
                </script>
                    @endsection
@yield('script')

{{-- <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script> --}}

     {{-- </x-layout> --}}





