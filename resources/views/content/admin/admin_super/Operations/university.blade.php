@extends('static.layouts.admin')
@section('content')






    <div class="container">
        <div class="dashboard-header">
            <div>
                <h1 class="dashboard-title">لوحة إدارة الجامعات</h1>
                <p class="dashboard-subtitle">إدارة وتتبع بيانات الجامعات بسهولة</p>
            </div>
            <button class="btn btn-primary" onclick="openAddModal()">
                <i class="fas fa-plus"></i>
                إضافة جامعة جديدة
            </button>
        </div>

        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value" id="totalEmployees">{{$stats['total'] }}</div>
                    <div class="stat-label">إجمالي الجامعات</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value" id="activeEmployees">{{$stats['active'] }}</div>
                    <div class="stat-label">جامعات نشطات</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value" id="pendingEmployees">{{$stats['inactive'] }}</div>
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
            <h2 class="table-title">قائمة الجامعات</h2>

            <div class="search-container">
                <input type="text" class="search-input" id="searchInput" placeholder="البحث عن جامعة...">
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
            <table class="desktop-table" >
                <thead>
                    <tr>
                        <th>الرقم</th>
                        <th>الجامعة</th>
                        <th>التلفون</th>
                        <th>الهاتف الأرضي </th>
                        <th>العنوان</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody id="researchTableBody" id="employeesTableDesktop">
                @foreach ($universities as $university)
                <tr>
                <td>{{ $university->id }}</td>

                        <td>
                            <div class="employee-info">
                                <div class="employee-details">
                                    <div class="employee-name">{{ $university->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="employee-info">
                                <div class="employee-details">
                                    <div class="employee-number">{{ $university->number }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="employee-info">
                                <div class="employee-details">
                                    <div class="employee-phone">{{ $university->phone }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="employee-info">
                                <div class="employee-details">
                                    <div class="employee-address">{{ $university->address }}</div>
                                </div>
                            </div>
                        </td>
                        <td>

                            <div class="employee-info">
                                <div class="employee-details">
                                    <div class="employee-name">
                                    @php
                        $statusClass = '';
                         $statusIcon = '';
                        if ($university->status === 'نشط') {
                    $statusClass = 'active';
                    $statusIcon = 'fa-check-circle';
                } else if ($university->status === 'غير نشط') {
                    $statusClass = 'inactive';
                    $statusIcon = 'fa-times-circle';
                } else {
                    $statusClass = 'pending';
                    $statusIcon = 'fa-clock';
                }
                @endphp
                                    <span class="status-{{$statusClass}}">
                                    <i class="fas {{$statusIcon}}"></i>
                                    {{ $university->status }}                               </span></div>
                                </div>
                            </div>
                        </td>

                        <td class="actions">
                        <!-- <a  onclick="editEmployee({{ json_encode($university) }})"href="{{ route('universities.edit', $university->id) }}">Edit</a> -->


                            <button class="action-btn edit tooltip" style="font-size:15px;" onclick="editEmployee({{ $university->id  }},
                               '{{ $university->name }}','{{ $university->number }}',
                               '{{ $university->phone }}','{{ $university->address }}','{{ $university->status }}')">

                               <span class="tooltip-text">تعديل</span>
                               <i class="fas fa-edit" style=" font-size:15px;"></i>

                            </button>
                            <!-- <button class="action-btn delete tooltip" onclick="deleteEmployee({{ $university->id  }})">
                                <i class="fas fa-trash-alt"></i>
                                <span class="tooltip-text">حذف</span>
                            </button> -->
                            <!-- <button class="action-btn tooltip" onclick="toggleDropdown(${employee.id}, event)">
                                <i class="fas fa-ellipsis-v"></i>
                                <span class="tooltip-text">المزيد</span>
                            </button> -->
                        </td>
                    </tr> @endforeach               </tbody>
            </table>

            <div id="emptyStateDesktop" class="empty-state" style="display: none;">
                <div class="empty-icon">
                    <i class="fas fa-user-slash"></i>
                </div>
                <h3 class="empty-title">لا يوجد جامعات</h3>
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
            @foreach ($universities as $university)
            <div class="employee-card">
                        <div class="card-header">
                            <div class="card-avatar"></div>
                            <div class="card-title">
                                <div class="card-name">{{ $university->name }} </div>
                            </div>
                            <div class="card-status">
                                <span class="status-badge ${statusClass}">
                                    <i class="fas ${statusIcon}"></i>
                                    {{ $university->status }}                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                        <div class="card-info-item">
                                <div class="card-info-value">التلفون</div>
                                <div class="card-info-label"> {{ $university->number }}</div>

                            </div>
                            <div class="card-info-item">
                                <div class="card-info-value">الهاتف الأرضي</div>
                                <div class="card-info-label"> {{ $university->phone }}</div>

                            </div>
                            <div class="card-info-item">
                                <div class="card-info-value">العنوان</div>
                                <div class="card-info-label"> {{ $university->address }}</div>

                            </div>

                        </div>
                        <div class="card-footer">

                            <div class="card-actions">

                                <!-- <button class="card-action-btn delete" onclick="deleteEmployee({{ $university->id  }})">
                                    <i class="fas fa-trash-alt"></i>
                                </button> -->
                                <div class="card-date">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $university->created_at }}
                            </div>
                                <button class="card-action-btn edit" onclick="editEmployee({{ $university->id  }},
                               '{{ $university->name }}','{{ $university->number }}',
                               '{{ $university->phone }}','{{ $university->address }}','{{ $university->status }}')">
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
            <div class="pagination-info">عرض <span id="currentShowing">0</span> من <span id="totalItems">0</span> موظف</div>

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
                <h2 class="modal-title" id="modalTitle">إضافة جامعة جديدة</h2>
                <button class="close-btn" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form  action="{{ route('universities.store')  }}" method="POST" >
                @csrf

                    <div class="form-group">
                        <label class="form-label" for="name">اسم الجامعة </label>
                        <input type="text" class="form-input" name="name"  placeholder="أدخل اسم الجامعة"  required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="email"> التلفون</label>
                        <input type="text" class="form-input"  name="number"  placeholder="أدخل رقم التلفون" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="email"> الهاتف الأرضي</label>
                        <input type="text" class="form-input" name="phone"  placeholder="أدخل رقم الهاتف الأرضي" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="email"> العنوان</label>
                        <input type="text" class="form-input" name="address"   placeholder="أدخل عنوان الجامعة" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="status">الحالة</label>
                        <select class="form-select"  name="status"  required>
                            <option value="">اختر الحالة</option>
                            <option value="نشط">نشط</option>
                            <option value="غير نشط">غير نشط</option>
                        </select>
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
                <h2 class="modal-title" >تعديل جامعة </h2>
                <button class="close-btn" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">


            <form id="editUniversityForm" action="{{ route('universities.update', 0) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="hidden" id="id" name="id" value="{{ $university->id }}">

    <div class="form-group">
    <label class="form-label" for="name">اسم الجامعة </label>
    <input type="text" class="form-input" id="name" name="name" placeholder="أدخل اسم الموظف" value="{{ $university->name }}" required>
    </div>
    <div class="form-group">
    <label class="form-label" for="email"> تلفون</label>
    <input type="number" class="form-input" id="number" name="number" placeholder="رقم الهاتف" value="{{ $university->number }}" required>
    </div>
    <div class="form-group">
    <label class="form-label" for="email"> الهاتف الأرضي</label>
    <input type="number" class="form-input" id="phone" name="phone" placeholder="رقم الهاتف" value="{{ $university->phone }}" required>
    </div>
    <div class="form-group">
    <label class="form-label" for="email"> العنوان</label>
    <input type="text" class="form-input" id="address" name="address" placeholder="العنوان" value="{{ $university->address }}" required>
    </div>
    <div class="form-group">
        <label class="form-label" for="status">الحالة</label>
        <select class="form-select" id="status" name="status" required>
            <option value="">اختر الحالة</option>
            <option value="نشط" {{ $university->status == 'نشط' ? 'selected' : '' }}>نشط</option>
            <option value="غير نشط" {{ $university->status == 'غير نشط' ? 'selected' : '' }}>غير نشط</option>
        </select>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-cancel" onclick="closeModal()">إلغاء</button>
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
                document.getElementById('currentShowing').textContent = '0';
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
            document.getElementById('currentShowing').textContent = paginatedEmployees.length;
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


                tableBodyDesktop.innerHTML += desktopRow;
                cardsContainerMobile.innerHTML += mobileCard;
            });
        }

        // تحديث الإحصائيات


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

        // فتح نافذة تأكيد الحذف
        function deleteEmployee(id) {
            document.getElementById('id').value = id;
            document.getElementById('delet').action = "{{ route('universities.destroy', '') }}" + '/' + id;

            // document.getElementById('id').value = id;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        // إغلاق نافذة تأكيد الحذف
        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        // تأكيد الحذف
        function confirmDelete() {
            const id = parseInt(document.getElementById('id').value);

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
        // document.getElementById('searchInput').addEventListener('input', function() {
        //     currentPage = 1;
        //     displayEmployees();
        // });

        // إغلاق القائمة المنسدلة عند النقر خارجها
        document.addEventListener('click', function() {
            document.getElementById('actionsDropdown').style.display = 'none';
        });
    });
    function openAddModal() {

            document.getElementById('modalTitle').textContent = 'إضافة جامعة جديدة';

            // تعيين تاريخ اليوم كتاريخ افتراضي للتعيين

            document.getElementById('employeeModal').style.display = 'flex';
        }

        // فتح نافذة التعديل
        function editEmployee(id, name, number, phone, address, status) {
    document.getElementById('id').value = id;
    document.getElementById('name').value = name;
    document.getElementById('number').value = number;
    document.getElementById('phone').value = phone;
    document.getElementById('address').value = address;
    document.getElementById('status').value = status;

    // تحديث action URL للنموذج
    document.getElementById('editUniversityForm').action = "{{ route('universities.update', '') }}" + '/' + id;

    // إظهار النموذج
    document.getElementById('employeeModall').style.display = 'flex';
}

        // إغلاق نافذة الإضافة/التعديل
        function closeModal() {
            document.getElementById('employeeModal').style.display = 'none';
            document.getElementById('employeeModall').style.display = 'none';

        }

        // عرض البيانات عند تحميل الصفحة
        window.onload = displayEmployees;
    </script>
    @yield('script')


