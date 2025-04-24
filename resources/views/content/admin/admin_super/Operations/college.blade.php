@extends('static.layouts.admin')
@section('content')






    <div class="container">
        <div class="dashboard-header">
            <div>
                {{-- <h1 class="dashboard-title">لوحة إدارة الكليات</h1> --}}
                <p class="dashboard-subtitle">إدارة وتتبع بيانات الكليات بسهولة</p>
            </div>
            <button class="btn btn-primary" onclick="openAddModal()">
                <i class="fas fa-plus"></i>
                إضافة كلية جديدة
            </button>
        </div>

        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value" id="totalEmployees">{{$stats['total'] }}</div>
                    <div class="stat-label">إجمالي الكليات</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value" id="activeEmployees"></div>
                    <div class="stat-label">جامعات نشطات</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value" id="pendingEmployees"></div>
                    <div class="stat-label"> جامعات غير نشطات</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon red">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value" id="inactiveEmployees">0</div>
                    <div class="stat-label">موظفين غير نشطين</div>
                </div>
            </div>
        </div>

        <div class="table-header">
            <h2 class="table-title">قائمة الكليات</h2>

            <div class="search-container">
                <input type="text" class="search-input" id="searchInput" placeholder="البحث عن كلية...">
                <i class="fas fa-search search-icon"></i>
            </div>

            <div class="actions-container">
                <button class="btn btn-outline">
                    <i class="fas fa-filter"></i>
                    تصفية
                </button>
                <button class="btn btn-outline">
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
                        <th>الرقم</th>
                        <th>الكلية</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody id="researchTableBody">
                @foreach ($colloges as $colloge)
                <tr>
                <td>{{ $colloge->id }}</td>

                        <td>
                            <div class="employee-info">
                                <div class="employee-details">
                                    <div class="employee-name">{{ $colloge->coll_name }}</div>
                                </div>
                            </div>
                        </td>



                        <td class="actions">


                            <button class="action-btn edit tooltip" style="font-size:15px;" onclick="editEmployee({{ $colloge->id }},
                               '{{ $colloge->coll_name }}')">

                               <span class="tooltip-text">تعديل</span>
                               <i class="fas fa-edit" style=" font-size:15px;"></i>

                            </button>

                        </td>
                    </tr> @endforeach               </tbody>
            </table>

            <div id="emptyStateDesktop" class="empty-state" style="display: none;">
                <div class="empty-icon">
                    <i class="fas fa-user-slash"></i>
                </div>
                <h3 class="empty-title">لا يوجد الكليات</h3>
                <p class="empty-description">لم يتم العثور على أي موظفين. يمكنك إضافة موظف جديد بالنقر على زر "                    إضافة جامعة جديدة".</p>
                <button class="btn btn-primary" onclick="openAddModal()">
                    <i class="fas fa-plus"></i>
                    إضافة جامعة جديدة
                </button>
            </div>
        </div>

        <!-- عرض البطاقات للشاشات الصغيرة -->

        <div class="mobile-cards" id="employeesCardsMobile">
            <!-- سيتم إضافة البطاقات هنا عن طريق JavaScript -->
            @foreach ($colloges as $colloge)
            <div class="employee-card">
                        <div class="card-header">
                            <div class="card-title">
                                <div class="card-name">{{ $colloge->coll_name }} </div>
                            </div>

                        </div>

                        <div class="card-footer">

                            <div class="card-actions">


                                <div class="card-date">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $colloge->created_at }}                            </div>
                                <button class="card-action-btn edit" onclick="editEmployee({{ $colloge->id }},
                               '{{ $colloge->coll_name }}')">
                               <i class="fas fa-edit" style=" font-size:15px;"></i>
                               </button>
                            </div>
                        </div>
                    </div>
                    @endforeach        </div>

        <div id="emptyStateMobile" class="empty-state" style="display: none;">
            <div class="empty-icon">
                <i class="fas fa-user-slash"></i>
            </div>
            <h3 class="empty-title">لا يوجد جامعات</h3>
            <p class="empty-description">لم يتم العثور على أي موظفين. يمكنك إضافة موظف جديد بالنقر على زر "إضافة موظف جديد".</p>
            <button class="btn btn-primary" onclick="openAddModal()">
                <i class="fas fa-plus"></i>
                إضافة جامعة جديدة
            </button>
        </div>

        <div class="pagination">
            <!-- <div class="pagination-info">عرض <span id="currentShowing">0</span> من <span id="totalItems">0</span> موظف</div> -->

            <div class="pagination-controls">
                <button class="pagination-btn" id="prevPage" disabled>
                    <i class="fas fa-chevron-right"></i>
                </button>
                <button class="pagination-btn active">1</button>
                <button class="pagination-btn">2</button>
                <button class="pagination-btn">3</button>
                <button class="pagination-btn" id="nextPage">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- نافذة الإضافة/ -->

    <div class="modal" id="employeeModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="modalTitle">إضافة كلية جديدة</h2>
                <button class="close-btn" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form  action="{{ route('colloges.store')  }}" method="POST" >
                @csrf

                    <div class="form-group">
                        <label class="form-label" for="name">اسم الكلية </label>
                        <input type="text" class="form-input" name="coll_name"  placeholder="أدخل اسم الكلية"  required>
                    </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" onclick="closeModal()">إلغاء</button>
                <button type="submit" class="btn btn-save">حفظ</button>
            </div>                </form>
            </div>

        </div>
    </div>
        <!-- نافذة التعديل/ -->



<div class="modall" id="employeeModall" >
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" >تعديل كلية </h2>
                <button class="close-btn" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">


            <form id="editUniversityForm" action="{{ route('colloges.update', 0) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="hidden" id="id" name="id" value="{{ $colloge->id }}">

    <div class="form-group">
    <label class="form-label" for="name">اسم الكلية </label>
    <input type="text" class="form-input" id="coll_name" name="coll_name" placeholder="أدخل اسم الكلية" value="{{ $colloge->coll_name }}" required>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-cancel">إلغاء</button>
        <button type="submit" class="btn btn-save">حفظ</button>
    </div>
</form>
            </div>

        </div>
    </div>



    <!-- نافذة تأكيد الحذف -->
    <div class="modal" id="deleteModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">تأكيد الحذف</h2>
                <button class="close-btn" onclick="closeDeleteModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <p>هل أنت متأكد من رغبتك في حذف هذا الموظف؟ هذا الإجراء لا يمكن التراجع عنه.</p>
                <input type="hidden" id="id" >
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" onclick="closeDeleteModal()">إلغاء</button>
                <form id="delet" action="{{ route('universities.destroy', 0) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete-confirm" >حذف</button>

                        </form>
            </div>
        </div>
    </div>

    <!-- قائمة منسدلة للإجراءات -->
    <div class="dropdown-menu" id="actionsDropdown">
        <div class="dropdown-item" onclick="viewEmployee()">
            <i class="fas fa-eye"></i>
            عرض التفاصيل
        </div>
        <div class="dropdown-item" onclick="editEmployeeFromDropdown()">
            <i class="fas fa-edit"></i>
            تعديل
        </div>
        <div class="dropdown-divider"></div>
        <div class="dropdown-item delete" onclick="deleteEmployeeFromDropdown()">
            <i class="fas fa-trash-alt"></i>
            حذف
        </div>
    </div>
    @endsection

    <script>
      document.addEventListener('DOMContentLoaded', function() {

document.getElementById('searchInput').addEventListener('input', handleSearch);

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
    });}
        // بيانات الموظفين


        // متغيرات للصفحات
        let currentPage = 1;
        let itemsPerPage = 5;
        let selectedEmployeeId = null;

        // عرض بيانات الموظفين
        function displayEmployees() {
            const tableBodyDesktop = document.getElementById('employeesTableDesktop');
            const cardsContainerMobile = document.getElementById('employeesCardsMobile');
            const emptyStateDesktop = document.getElementById('emptyStateDesktop');
            const emptyStateMobile = document.getElementById('emptyStateMobile');
            const filteredEmployees = filterEmployees();

            // تحديث الإحصائيات
            updateStats();

            // التحقق من وجود موظفين
            if (filteredEmployees.length === 0) {
                tableBodyDesktop.innerHTML = '';
                cardsContainerMobile.innerHTML = '';
                emptyStateDesktop.style.display = 'block';
                emptyStateMobile.style.display = 'block';
                // document.getElementById('currentShowing').textContent = '0';
                document.getElementById('totalItems').textContent = '0';
                return;
            }

            emptyStateDesktop.style.display = 'none';
            emptyStateMobile.style.display = 'none';

            // حساب الصفحات
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, filteredEmployees.length);
            const paginatedEmployees = filteredEmployees.slice(startIndex, endIndex);

            // تحديث معلومات الصفحات
            // document.getElementById('currentShowing').textContent = paginatedEmployees.length;
            document.getElementById('totalItems').textContent = filteredEmployees.length;

            // تحديث أزرار الصفحات
            document.getElementById('prevPage').disabled = currentPage === 1;
            document.getElementById('nextPage').disabled = endIndex >= filteredEmployees.length;

            // تحديث الجدول للشاشات الكبيرة
            tableBodyDesktop.innerHTML = '';

            // تحديث البطاقات للشاشات الصغيرة
            cardsContainerMobile.innerHTML = '';

            paginatedEmployees.forEach(employee => {
                // تحديد لون القسم
                let departmentClass = 'dev';
                if (employee.department === 'التسويق') departmentClass = 'marketing';
                if (employee.department === 'الموارد البشرية') departmentClass = 'hr';
                if (employee.department === 'المبيعات') departmentClass = 'sales';
                if (employee.department === 'المالية') departmentClass = 'finance';

                // تحديد لون الحالة وأيقونتها
                let statusClass = '';
                let statusIcon = '';
                if (employee.status === 'نشط') {
                    statusClass = 'active';
                    statusIcon = 'fa-check-circle';
                } else if (employee.status === 'غير نشط') {
                    statusClass = 'inactive';
                    statusIcon = 'fa-times-circle';
                } else {
                    statusClass = 'pending';
                    statusIcon = 'fa-clock';
                }

                // الحصول على الحرف الأول من اسم الموظف
                const firstLetter = employee.name.charAt(0);

                // تنسيق تاريخ التعيين


                // إنشاء صف الجدول للشاشات الكبيرة


                // إنشاء بطاقة للشاشات الصغيرة
                const mobileCard = `
                    <div class="employee-card">
                        <div class="card-header">
                            <div class="card-avatar">${firstLetter}</div>
                            <div class="card-title">
                                <div class="card-name">${employee.name}</div>
                                <div class="card-email">${employee.email}</div>
                            </div>
                            <div class="card-status">
                                <span class="status-badge ${statusClass}">
                                    <i class="fas ${statusIcon}"></i>
                                    ${employee.status}
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-info-item">
                                <div class="card-info-label">القسم</div>
                                <div class="card-info-value">
                                    <span class="department-badge ${departmentClass}">${employee.department}</span>
                                </div>
                            </div>
                            <div class="card-info-item">
                                <div class="card-info-label">تاريخ التعيين</div>
                                <div class="card-info-value">${formattedDate}</div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="card-date">
                                <i class="fas fa-calendar-alt"></i>
                                تم التعيين في ${formattedDate}
                            </div>
                            <div class="card-actions">
                                <button class="card-action-btn edit" onclick="editEmployee(${employee.id})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="card-action-btn delete" onclick="deleteEmployee(${employee.id})">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;

                tableBodyDesktop.innerHTML += desktopRow;
                cardsContainerMobile.innerHTML += mobileCard;
            });
        }

        // تحديث الإحصائيات
        function updateStats() {
            const totalEmployees = employees.length;
            const activeEmployees = employees.filter(emp => emp.status === 'نشط').length;
            const inactiveEmployees = employees.filter(emp => emp.status === 'غير نشط').length;
            const pendingEmployees = employees.filter(emp => emp.status === 'معلق').length;

            document.getElementById('totalEmployees').textContent = totalEmployees;
            document.getElementById('activeEmployees').textContent = activeEmployees;
            document.getElementById('inactiveEmployees').textContent = inactiveEmployees;
            document.getElementById('pendingEmployees').textContent = pendingEmployees;
        }

        // تصفية الموظفين حسب البحث
        function filterEmployees() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();

            if (!searchTerm) {
                return [...universities];
            }

            return universities.filter(university =>
            university.name.toLowerCase().includes(searchTerm) ||
            university.number.toLowerCase().includes(searchTerm) ||
            university.phone.toLowerCase().includes(searchTerm) ||
            university.status.toLowerCase().includes(searchTerm)
            );
        }

        // فتح نافذة الإضافة


        // فتح نافذة التعديل


        // فتح نافذة تأكيد الحذف
        function deleteEmployee(id_university) {
            document.getElementById('id_university').value = id_university;
            document.getElementById('delet').action = "{{ route('universities.destroy', '') }}" + '/' + id_university;

            // document.getElementById('id_university').value = id_university;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        // إغلاق نافذة تأكيد الحذف
        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        // تأكيد الحذف
        function confirmDelete() {
            const id_university = parseInt(document.getElementById('id_university').value);

            // employees = employees.filter(emp => emp.id !== id);
            displayEmployees();
            closeDeleteModal();
        }

        // حفظ بيانات الموظف (إضافة/تعديل)



        // تبديل القائمة المنسدلة
        function toggleDropdown(id, event) {
            event.stopPropagation();
            selectedEmployeeId = id;

            const dropdown = document.getElementById('actionsDropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            //dropdown.classList.add('show');

            // تحديد موقع القائمة المنسدلة
            const button = event.currentTarget;
            const rect = button.getBoundingClientRect();
            dropdown.style.top = `${rect.bottom + window.scrollY}px`;
            dropdown.style.left = `${rect.left + window.scrollX}px`;
        }

        // عرض تفاصيل الموظف
        function viewEmployee() {
            // يمكن تنفيذ هذه الوظيفة لعرض تفاصيل الموظف
            alert(`عرض تفاصيل الموظف رقم ${selectedEmployeeId}`);
            document.getElementById('actionsDropdown').style.display = 'none';
        }

        // تعديل الموظف من القائمة المنسدلة
        function editEmployeeFromDropdown() {
            editEmployee(selectedEmployeeId);
            document.getElementById('actionsDropdown').style.display = 'none';
        }

        // حذف الموظف من القائمة المنسدلة
        function deleteEmployeeFromDropdown() {
            deleteEmployee(selectedEmployeeId);
            document.getElementById('actionsDropdown').style.display = 'none';
        }

        // الانتقال إلى الصفحة السابقة
        document.getElementById('prevPage').addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage--;
                displayEmployees();
            }
        });

        // الانتقال إلى الصفحة التالية
        document.getElementById('nextPage').addEventListener('click', function() {
            const filteredEmployees = filterEmployees();
            const totalPages = Math.ceil(filteredEmployees.length / itemsPerPage);

            if (currentPage < totalPages) {
                currentPage++;
                displayEmployees();
            }
        });

        // البحث في الجدول
        document.getElementById('searchInput').addEventListener('input', function() {
            currentPage = 1;
            displayEmployees();
        });

        // إغلاق القائمة المنسدلة عند النقر خارجها
        document.addEventListener('click', function() {
            document.getElementById('actionsDropdown').style.display = 'none';
        });

        // عرض البيانات عند تحميل الصفحة
        window.onload = displayEmployees;
      });
      function openAddModal() {

            // document.getElementById('modalTitle').textContent = 'إضافة جامعة جديدة';

            // تعيين تاريخ اليوم كتاريخ افتراضي للتعيين

            document.getElementById('employeeModal').style.display = 'flex';
        }
        function editEmployee(id, coll_name) {
    document.getElementById('id').value = id;
    document.getElementById('coll_name').value = coll_name;

    // تحديث action URL للنموذج
    document.getElementById('editUniversityForm').action = "{{ route('colloges.update', '') }}" + '/' + id;

    // إظهار النموذج
    document.getElementById('employeeModall').style.display = 'flex';
}

        // إغلاق نافذة الإضافة/التعديل
        function closeModal() {
            document.getElementById('employeeModal').style.display = 'none';
            document.getElementById('employeeModall').style.display = 'none';

        }
    </script>
    @yield('script')


