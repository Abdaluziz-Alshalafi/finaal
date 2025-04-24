@extends('static.layouts.student')

@section('title')
Create Project
@endsection





@section('content')
<div class="container">
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title">لوحة إدارة الأبحاث العلمية</h1>
            <p class="dashboard-subtitle">إدارة وتتبع الأبحاث والطلاب والمشرفين</p>
        </div>
        <button class="btn btn-primary" id="addResearchBtn">
            <i class="fas fa-plus"></i>
            إضافة بحث جديد
        </button>
    </div>

    <div class="table-header">
        <h2 class="table-title">قائمة الأبحاث العلمية</h2>

        <div class="search-container">
            <input type="text" class="search-input" id="searchInput" placeholder="البحث عن بحث أو طالب أو مشرف...">
            <i class="fas fa-search search-icon"></i>
        </div>

        <div class="actions-container">
            <button class="btn btn-outline" id="filterBtn">
                <i class="fas fa-filter"></i>
                تصفية
            </button>
            <button class="btn btn-outline" id="exportBtn">
                <i class="fas fa-download"></i>
                تصدير
            </button>
        </div>
    </div>

    <!-- عرض الجدول للشاشات الكبيرة -->
    <div class="table-container desktop-table-container">
        <table class="desktop-table">
            <thead>
                <tr>
                    <th>عنوان البحث</th>
                    <th>الطلاب</th>
                    <th>المشرفين</th>
                    <th>الحالة</th>
                    <th>تاريخ البدء</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody id="researchTableBody">
                @forelse($team as $item)
                    <tr data-id="{{ $item->id }}">
                        <td>
                            <div class="research-info">
                                @if($item->topics->isNotEmpty())
                                    <div class="research-title">{{ $item->topics->first()->sub1 ?? 'لا يوجد عنوان' }}</div>
                                    <div class="research-description">{{ $item->topics->first()->describtion1 ?? 'لا يوجد وصف' }}</div>
                                @else
                                    <div class="research-title">لا يوجد عنوان</div>
                                    <div class="research-description">لا يوجد وصف</div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="student-list">
                                @forelse($item->requests as $request)
                                    <div class="student-item">
                                        <div class="avatar">{{ substr($request->student->name ?? 'غ', 0, 1) }}</div>
                                        <div>
                                            <div class="person-name">{{ $request->student->name ?? 'غير معروف' }}</div>
                                            <div class="person-info">{{ $request->student->student_id ?? 'غير معروف' }}</div>
                                        </div>
                                    </div>
                                @empty
                                    <div>لا يوجد طلاب</div>
                                @endforelse
                            </div>
                        </td>
                        <td>
                            <div class="supervisor-list">
                                @forelse($item->projectSupervisors as $supervisor)
                                    <div class="supervisor-item">
                                        <div class="avatar supervisor">{{ substr($supervisor->teacher->name ?? 'غ', 0, 1) }}</div>
                                        <div>
                                            <div class="person-name">{{ $supervisor->teacher->name ?? 'غير معروف' }}</div>
                                            <div class="person-info">{{ $supervisor->teacher->position ?? 'غير معروف' }}</div>
                                        </div>
                                    </div>
                                @empty
                                    <div>لا يوجد مشرفين</div>
                                @endforelse
                            </div>
                        </td>
                        <td>
                            @php
                                $statusClass = '';
                                $statusIcon = '';
                                $statusText = '';

                                switch($item->status ?? 'pending') {
                                    case 'completed':
                                        $statusClass = 'completed';
                                        $statusIcon = 'fa-check-circle';
                                        $statusText = 'مكتمل';
                                        break;
                                    case 'in-progress':
                                        $statusClass = 'in-progress';
                                        $statusIcon = 'fa-clock';
                                        $statusText = 'قيد التنفيذ';
                                        break;
                                    default:
                                        $statusClass = 'pending';
                                        $statusIcon = 'fa-hourglass-half';
                                        $statusText = 'قيد المراجعة';
                                }
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                <i class="fas {{ $statusIcon }}"></i>
                                {{ $statusText }}
                            </span>
                        </td>
                        <td>{{ $item->created_at ? $item->created_at->format('d M Y') : 'غير محدد' }}</td>
                        <td class="actions">
                            <button class="action-btn view tooltip" onclick="viewResearch({{ $item->id }})">
                                <i class="fas fa-eye"></i>
                                <span class="tooltip-text">عرض التفاصيل</span>
                            </button>
                            <button class="action-btn edit tooltip" onclick="editResearch({{ $item->id }})">
                                <i class="fas fa-edit"></i>
                                <span class="tooltip-text">تعديل</span>
                            </button>
                            <button class="action-btn delete tooltip" onclick="deleteResearch({{ $item->id }})">
                                <i class="fas fa-trash-alt"></i>
                                <span class="tooltip-text">حذف</span>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <h3 class="empty-title">لا توجد أبحاث</h3>
                                <p class="empty-description">لم يتم العثور على أي أبحاث. يمكنك إضافة بحث جديد بالنقر على زر "إضافة بحث جديد".</p>
                                <button class="btn btn-primary" id="addResearchEmptyBtn">
                                    <i class="fas fa-plus"></i>
                                    إضافة بحث جديد
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- عرض البطاقات للشاشات الصغيرة -->
    <div class="mobile-cards" id="researchCardsMobile">
        @forelse($team as $item)
            <div class="research-card" data-id="{{ $item->id }}">
                <div class="card-header">

                    @if($item->topics->isNotEmpty())
                        <div class="card-title">{{ $item->topics->first()->sub1 ?? 'لا يوجد عنوان' }}</div>
                        <div class="card-description">{{ $item->topics->first()->describtion1 ?? 'لا يوجد وصف' }}</div>
                    @else
                        <div class="card-title">لا يوجد عنوان</div>
                        <div class="card-description">لا يوجد وصف</div>
                    @endif

                    @php
                        $statusClass = '';
                        $statusIcon = '';
                        $statusText = '';

                        switch($item->status ?? 'pending') {
                            case 'completed':
                                $statusClass = 'completed';
                                $statusIcon = 'fa-check-circle';
                                $statusText = 'مكتمل';
                                break;
                            case 'in-progress':
                                $statusClass = 'in-progress';
                                $statusIcon = 'fa-clock';
                                $statusText = 'قيد التنفيذ';
                                break;
                            default:
                                $statusClass = 'pending';
                                $statusIcon = 'fa-hourglass-half';
                                $statusText = 'قيد المراجعة';
                        }
                    @endphp
                    <span class="status-badge {{ $statusClass }}">
                        <i class="fas {{ $statusIcon }}"></i>
                        {{ $statusText }}
                    </span>
                </div>

                <div class="card-body">
                    <div class="card-section">
                        <div class="card-section-title">
                            <i class="fas fa-user-graduate"></i>
                            الطلاب
                        </div>
                        <div class="student-list">
                            @forelse($item->requests as $request)
                                <div class="student-item">
                                    <div class="avatar">{{ substr($request->student->name ?? 'غ', 0, 1) }}</div>
                                    <div>
                                        <div class="person-name">{{ $request->student->name ?? 'غير معروف' }}</div>
                                        <div class="person-info">{{ $request->student->student_id ?? 'غير معروف' }}</div>
                                    </div>
                                </div>
                            @empty
                                <div>لا يوجد طلاب</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="card-section">
                        <div class="card-section-title">
                            <i class="fas fa-chalkboard-teacher"></i>
                            المشرفين
                        </div>
                        <div class="supervisor-list">
                            @forelse($item->projectSupervisors as $supervisor)
                                <div class="supervisor-item">
                                    <div class="avatar supervisor">{{ substr($supervisor->teacher->name ?? 'غ', 0, 1) }}</div>
                                    <div>
                                        <div class="person-name">{{ $supervisor->teacher->name ?? 'غير معروف' }}</div>
                                        <div class="person-info">{{ $supervisor->teacher->position ?? 'غير معروف' }}</div>
                                    </div>
                                </div>
                            @empty
                                <div>لا يوجد مشرفين</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="card-date">
                        <i class="fas fa-calendar-alt"></i>
                        تاريخ البدء: {{ $item->created_at ? $item->created_at->format('d M Y') : 'غير محدد' }}
                    </div>
                    <div class="card-actions">
                        <button class="card-action-btn view" onclick="viewResearch({{ $item->id }})">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="card-action-btn edit" onclick="editResearch({{ $item->id }})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="card-action-btn delete" onclick="deleteResearch({{ $item->id }})">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h3 class="empty-title">لا توجد أبحاث</h3>
                <p class="empty-description">لم يتم العثور على أي أبحاث. يمكنك إضافة بحث جديد بالنقر على زر "إضافة بحث جديد".</p>
                <button class="btn btn-primary" id="addResearchMobileEmptyBtn">
                    <i class="fas fa-plus"></i>
                    إضافة بحث جديد
                </button>
            </div>
        @endforelse
    </div>

    <!-- نافذة التعديل -->
    <div class="modal" id="editModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="modalTitle">تعديل بيانات البحث</h2>
                <button class="close-btn" id="closeModalBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="researchForm">
                    @csrf
                    <input type="hidden" id="researchId" name="id">
                    <div class="form-group">
                        <label class="form-label" for="title">عنوان البحث</label>
                        <input type="text" class="form-input" id="title" name="title" placeholder="أدخل عنوان البحث" required>
                        <div class="error-message" id="titleError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="description">وصف البحث</label>
                        <textarea class="form-input" id="description" name="description" rows="4" placeholder="أدخل وصف البحث" required></textarea>
                        <div class="error-message" id="descriptionError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="status">الحالة</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="">اختر الحالة</option>
                            <option value="pending">قيد المراجعة</option>
                            <option value="in-progress">قيد التنفيذ</option>
                            <option value="completed">مكتمل</option>
                        </select>
                        <div class="error-message" id="statusError"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" id="cancelBtn">إلغاء</button>
                <button type="button" class="btn btn-save" id="saveBtn">حفظ</button>
            </div>
        </div>
    </div>

    <!-- نافذة تأكيد الحذف -->
    <div class="modal" id="deleteModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">تأكيد الحذف</h2>
                <button class="close-btn" id="closeDeleteModalBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>هل أنت متأكد من رغبتك في حذف هذا البحث؟ هذا الإجراء لا يمكن التراجع عنه.</p>
                <input type="hidden" id="deleteResearchId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" id="cancelDeleteBtn">إلغاء</button>
                <button type="button" class="btn btn-delete-confirm" id="confirmDeleteBtn">حذف</button>
            </div>
        </div>
    </div>

    <!-- رسائل الإشعارات -->
    <div class="toast-container">
        <div class="toast" id="toast">
            <div class="toast-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="toast-content">
                <div class="toast-title">نجاح</div>
                <div class="toast-message" id="toastMessage"></div>
            </div>
            <button class="toast-close" id="toastClose">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
 @endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/research-table.css') }}">
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // متغيرات عامة
    let selectedResearchId = null;

    // الحصول على CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // إضافة مستمعي الأحداث
    document.getElementById('addResearchBtn').addEventListener('click', openAddModal);
    if (document.getElementById('addResearchEmptyBtn')) {
        document.getElementById('addResearchEmptyBtn').addEventListener('click', openAddModal);
    }
    if (document.getElementById('addResearchMobileEmptyBtn')) {
        document.getElementById('addResearchMobileEmptyBtn').addEventListener('click', openAddModal);
    }
    document.getElementById('closeModalBtn').addEventListener('click', closeModal);
    document.getElementById('cancelBtn').addEventListener('click', closeModal);
    document.getElementById('saveBtn').addEventListener('click', saveResearch);
    document.getElementById('closeDeleteModalBtn').addEventListener('click', closeDeleteModal);
    document.getElementById('cancelDeleteBtn').addEventListener('click', closeDeleteModal);
    document.getElementById('confirmDeleteBtn').addEventListener('click', confirmDelete);
    document.getElementById('searchInput').addEventListener('input', handleSearch);
    document.getElementById('toastClose').addEventListener('click', hideToast);

    // البحث في الجدول
    function handleSearch() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();

        // البحث في الجدول للشاشات الكبيرة
        const tableRows = document.querySelectorAll('#researchTableBody tr');
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        // البحث في البطاقات للشاشات الصغيرة
        const cards = document.querySelectorAll('.research-card');
        cards.forEach(card => {
            const text = card.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // فتح نافذة الإضافة
    function openAddModal() {
        document.getElementById('modalTitle').textContent = 'إضافة بحث جديد';
        document.getElementById('researchForm').reset();
        document.getElementById('researchId').value = '';

        // إعادة تعيين رسائل الخطأ
        clearErrors();

        document.getElementById('editModal').style.display = 'flex';
    }

    // تعريف الدوال العامة للتعامل مع الأحداث
    window.viewResearch = function(id) {
        // يمكن تنفيذ هذه الوظيفة لعرض تفاصيل البحث
        window.location.href = `/student/research/${id}`;
    };

    window.editResearch = function(id) {
        clearErrors();
        selectedResearchId = id;

        // جلب بيانات البحث من الخادم
        fetch(`/student/research/${id}/edit`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('حدث خطأ أثناء جلب بيانات البحث');
                }
                return response.json();
            })
            .then(data => {
                document.getElementById('modalTitle').textContent = 'تعديل بيانات البحث';
                document.getElementById('researchId').value = data.id;

                // تعبئة البيانات في النموذج
                if (data.topics && data.topics.length > 0) {
                    document.getElementById('title').value = data.topics[0].title || '';
                    document.getElementById('description').value = data.topics[0].description || '';
                }

                document.getElementById('status').value = data.status || 'pending';
                document.getElementById('editModal').style.display = 'flex';
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('خطأ', error.message, 'error');
            });
    };

    window.deleteResearch = function(id) {
        selectedResearchId = id;
        document.getElementById('deleteResearchId').value = id;
        document.getElementById('deleteModal').style.display = 'flex';
    };

    // إغلاق نافذة الإضافة/التعديل
    function closeModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    // إغلاق نافذة تأكيد الحذف
    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    // تأكيد الحذف
    function confirmDelete() {
        const id = document.getElementById('deleteResearchId').value;

        fetch(`/student/research/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('حدث خطأ أثناء حذف البحث');
            }
            return response.json();
        })
        .then(data => {
            closeDeleteModal();
            showToast('نجاح', 'تم حذف البحث بنجاح', 'success');

            // حذف الصف من الجدول
            const tableRow = document.querySelector(`#researchTableBody tr[data-id="${id}"]`);
            if (tableRow) {
                tableRow.remove();
            }

            // حذف البطاقة من العرض المحمول
            const card = document.querySelector(`.research-card[data-id="${id}"]`);
            if (card) {
                card.remove();
            }

            // التحقق من وجود أبحاث
            checkEmptyState();
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('خطأ', error.message, 'error');
        });
    }

    // حفظ بيانات البحث (إضافة/تعديل)
    function saveResearch() {
        clearErrors();

        const form = document.getElementById('researchForm');
        const formData = new FormData(form);
        const id = document.getElementById('researchId').value;

        // تحويل FormData إلى كائن JSON
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });

        // تحديد طريقة الطلب والعنوان
        const method = id ? 'PUT' : 'POST';
        const url = id ? `/student/research/${id}` : '/student/research';

        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw err;
                });
            }
            return response.json();
        })
        .then(data => {
            closeModal();
            showToast('نجاح', id ? 'تم تحديث بيانات البحث بنجاح' : 'تم إضافة البحث بنجاح', 'success');

            // إعادة تحميل الصفحة لتحديث البيانات
            // يمكن تحسين هذا لاحقًا لتحديث الصف/البطاقة بدلاً من إعادة تحميل الصفحة
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        })
        .catch(error => {
            console.error('Error:', error);

            // عرض رسائل الخطأ
            if (error.errors) {
                Object.keys(error.errors).forEach(key => {
                    const errorElement = document.getElementById(key + 'Error');
                    if (errorElement) {
                        errorElement.textContent = error.errors[key][0];
                    }
                });
            } else {
                showToast('خطأ', error.message || 'حدث خطأ أثناء حفظ البيانات', 'error');
            }
        });
    }

    // مسح رسائل الخطأ
    function clearErrors() {
        const errorElements = document.querySelectorAll('.error-message');
        errorElements.forEach(element => {
            element.textContent = '';
        });
    }

    // التحقق من وجود أبحاث
    function checkEmptyState() {
        const tableRows = document.querySelectorAll('#researchTableBody tr');
        const cards = document.querySelectorAll('.research-card');

        if (tableRows.length === 0) {
            // إظهار حالة الفراغ للجدول
            const emptyState = `
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <h3 class="empty-title">لا توجد أبحاث</h3>
                            <p class="empty-description">لم يتم العثور على أي أبحاث. يمكنك إضافة بحث جديد بالنقر على زر "إضافة بحث جديد".</p>
                            <button class="btn btn-primary" id="addResearchEmptyBtn">
                                <i class="fas fa-plus"></i>
                                إضافة بحث جديد
                            </button>
                        </div>
                    </td>
                </tr>
            `;
            document.getElementById('researchTableBody').innerHTML = emptyState;

            // إضافة مستمع الحدث للزر الجديد
            document.getElementById('addResearchEmptyBtn').addEventListener('click', openAddModal);
        }

        if (cards.length === 0) {
            // إظهار حالة الفراغ للبطاقات
            const emptyState = `
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3 class="empty-title">لا توجد أبحاث</h3>
                    <p class="empty-description">لم يتم العثور على أي أبحاث. يمكنك إضافة بحث جديد بالنقر على زر "إضافة بحث جديد".</p>
                    <button class="btn btn-primary" id="addResearchMobileEmptyBtn">
                        <i class="fas fa-plus"></i>
                        إضافة بحث جديد
                    </button>
                </div>
            `;
            document.getElementById('researchCardsMobile').innerHTML = emptyState;

            // إضافة مستمع الحدث للزر الجديد
            document.getElementById('addResearchMobileEmptyBtn').addEventListener('click', openAddModal);
        }
    }

    // عرض رسالة إشعار
    function showToast(title, message, type = 'success') {
        const toast = document.getElementById('toast');
        const toastTitle = toast.querySelector('.toast-title');
        const toastMessage = document.getElementById('toastMessage');
        const toastIcon = toast.querySelector('.toast-icon i');

        toastTitle.textContent = title;
        toastMessage.textContent = message;

        // تعيين نوع الإشعار
        toast.className = 'toast';
        toastIcon.className = '';

        if (type === 'success') {
            toast.classList.add('success');
            toastIcon.classList.add('fas', 'fa-check-circle');
            toast.querySelector('.toast-icon').style.backgroundColor = 'var(--success-light)';
            toast.querySelector('.toast-icon').style.color = 'var(--success)';
        } else if (type === 'error') {
            toast.classList.add('error');
            toastIcon.classList.add('fas', 'fa-times-circle');
            toast.querySelector('.toast-icon').style.backgroundColor = 'var(--danger-light)';
            toast.querySelector('.toast-icon').style.color = 'var(--danger)';
        } else if (type === 'warning') {
            toast.classList.add('warning');
            toastIcon.classList.add('fas', 'fa-exclamation-circle');
            toast.querySelector('.toast-icon').style.backgroundColor = 'var(--warning-light)';
            toast.querySelector('.toast-icon').style.color = 'var(--warning)';
        }

        // إظهار الإشعار
        toast.classList.add('show');

        // إخفاء الإشعار بعد 5 ثوانٍ
        setTimeout(hideToast, 5000);
    }

    // إخفاء رسالة الإشعار
    function hideToast() {
        const toast = document.getElementById('toast');
        toast.classList.remove('show');
    }
});
</script>
@endsection