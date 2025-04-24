@extends('static.layouts.admin')


    @section('title')
    Dashboard
    @endsection
    @section('content')
    <style>
    .details-box {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.8s ease, opacity 0.8s ease-in-out;
    opacity: 0;
}

.details-box.open {
    max-height: 1000px; /* قيمة كبيرة لتسمح بالعرض الكامل */
    opacity: 1;
}
.table-container {
        background-color: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        margin-bottom: 30px;
    }
    desktop-table {
        width: 100%;
        border-collapse: collapse;
    }

    .desktop-table thead {
        background-color: var(--bg-light);
        border-bottom: 1px solid var(--border-light);
    }

    .desktop-table th {
        padding: 16px 20px;
        text-align: right;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .desktop-table td {
        padding: 16px 20px;
        border-bottom: 1px solid var(--border-light);
        font-size: 0.9375rem;
        color: var(--text-dark);
        vertical-align: middle;
    }

    .desktop-table tr:last-child td {
        border-bottom: none;
    }

    .desktop-table tr {
        transition: var(--transition);
    }

    .desktop-table tbody tr:hover {
        background-color: var(--primary-light);
    }
    .search-container {
            max-width: 50%;
            width: 30%;
            margin:15px;
        }
        .search-input {
        width: 100%;
        padding: 12px 15px 12px 40px;
        border: 1px solid var(--border-light);
        border-radius: var(--radius-full);
        font-size: 0.875rem;
        outline: none;
        transition: var(--transition);
        background-color: white;
    }

    .search-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
    }
    .h{
        margin:4px;
    }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<head>    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
    <div class="container">
    <h2 class="mb-4">إدارة الفرق</h2>
<div class="search-container"> 
    <input type="text" id="searchInput" placeholder="ابحث برقم المشروع..." class="search-input">
    <i class="fas fa-search search-icon"></i>
</div> <div id="team-cards">
        @foreach($topics as $topic)
        <div class="card mb-4" >
            <div class="card-header d-flex justify-content-between align-items-center" >
                <span>فريق رقم: {{ $topic->team_id }}</span>
                <button class="btn btn-secondary" onclick="toggleDetails({{ $topic->id }})">عرض معلومات الفريق<i class="fas fa-chevron-down"></i></button>
                
            </div>
            <div class="details-box" id="details-{{ $topic->id }}"   >
            <strong><i class="fas fa-users"></i>عنوان المشروع: </strong>  <span id="sub1-{{ $topic->id }}">{{ $topic->sub1 }}</span>
                <p><strong><i class="fas fa-project-diagram title-icon"></i>الوصف: </strong> <span id="desc1-{{ $topic->id }}">{{ $topic->describtion1 }}</span></p>
                <button class="btn btn-secondary btn-sm" onclick="showEditModal({{ $topic->id }}, '{{ $topic->sub1 }}', `{{ $topic->describtion1 }}`)">تعديل</button>
                <hr>
                <strong><i class="fas fa-users"></i> أعضاء الفريق:</strong>
            <div class="table-container desktop-table-container">    
                <table class="desktop-table">
                    <thead><tr><th>الاسم</th><th>رقم أكاديمي</th><th>إجراءت</th></tr></thead>
                    <tbody id="members-{{ $topic->team_id }}">
                        @foreach(App\Models\Request::where('team_id', $topic->team_id)->get() as $member)
                            @php $student = App\Models\Student::find($member->student_id); @endphp
                            <tr id="member-{{ $student->id }}">
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->Academic_number }}</td>
                                <td><button class=
                                "h" onclick="deleteMember({{ $topic->team_id }}, {{ $student->id }})"  data-toggle="tooltip" title="حذف الطالب "><i class="fas fa-trash-alt"></i></button>
                                <button  onclick="showAddMemberModal({{ $topic->team_id }})" data-toggle="tooltip" title="اضافة طالب للفريق"> <i class="fas fa-plus"></i></button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
                
                <hr>
                <strong><i class="fas fa-user-tie"></i> مشرف الفريق:</strong>
                @php $supervisor = App\Models\Project_supervisors::where('team_id', $topic->team_id)->first(); @endphp
                <p id="current-supervisor-{{ $topic->team_id }}">
                    {{ $supervisor ? App\Models\Teacher::find($supervisor->id_teachers)->name : 'لم يتم تعيين مشرف' }}
                </p>
                <button class="btn btn-secondary btn-sm" onclick="showSupervisorModal({{ $topic->team_id }})">تعديل المشرف</button>
                

            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Edit Topic Modal -->
<div class="modal" id="editModal" style="display:none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5>تعديل المشروع</h5></div>
      <div class="modal-body">
        <input type="hidden" id="editTopicId">
        <label>العنوان:</label>
        <input type="text" class="form-control" id="editSub1">
        <label>الوصف:</label>
        <textarea class="form-control" id="editDesc1"></textarea>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" onclick="saveTopic()">حفظ</button>
        <button class="btn btn-secondary" onclick="closeModal('editModal')">إغلاق</button>
      </div>
    </div>
  </div>
</div>

<!-- Add Member Modal -->
<div class="modal" id="addMemberModal" style="display:none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5>إضافة عضو</h5></div>
      <div class="modal-body">
        <input type="hidden" id="addTeamId">
        <label>الرقم الأكاديمي:</label>

        <input type="text" class="form-control" id="academicNumber" onkeyup="fetchStudentName(this.value)">
        <p id="studentName"></p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" onclick="addMember()">حفظ</button>
        <button class="btn btn-secondary" onclick="closeModal('addMemberModal')">إغلاق</button>
      </div>
    </div>
  </div>
</div>

<!-- Supervisor Modal -->
<div class="modal" id="supervisorModal" style="display:none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5>تغيير المشرف</h5></div>
      <div class="modal-body">
        <input type="hidden" id="supervisorTeamId">
        <select class="form-control" id="supervisorSelect">
          @foreach($teachers as $teacher)
            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" onclick="updateSupervisor()">تحديث</button>
        <button class="btn btn-secondary" onclick="closeModal('supervisorModal')">إغلاق</button>
      </div>
    </div>
  </div>
</div>

<script>

function toggleDetails(id) {
    const element =document.getElementById('details-' + id);
    element.classList.toggle('open');
}

function showEditModal(id, sub1, desc1) {
    document.getElementById('editTopicId').value = id;
    document.getElementById('editSub1').value = sub1;
    document.getElementById('editDesc1').value = desc1;
    document.getElementById('editModal').style.display = 'block';
}

function saveTopic() {
    let id = document.getElementById('editTopicId').value;
    let sub1 = document.getElementById('editSub1').value;
    let desc1 = document.getElementById('editDesc1').value;

    fetch('/team/update-topic', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ topic_id: id, sub1, describtion1: desc1 })
    }).then(() => location.reload());
}

function deleteMember(team_id, student_id) {
    if (!confirm('هل أنت متأكد من الحذف؟')) return;
    fetch('/team/delete-member', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ team_id, student_id })
    }).then(() => document.getElementById('member-' + student_id).remove());
}

function showAddMemberModal(team_id) {
    document.getElementById('addTeamId').value = team_id;
    document.getElementById('addMemberModal').style.display = 'block';
}

function fetchStudentName(value) {
    fetch('/api/student-by-academic/' + value)
        .then(res => res.json())
        .then(data => document.getElementById('studentName').innerText = data.name || '');
}

function addMember() {
    let team_id = document.getElementById('addTeamId').value;
    let academic_number = document.getElementById('academicNumber').value;
    fetch('/team/add-member', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ team_id, academic_number })
    }).then(() => location.reload());
}

function showSupervisorModal(team_id) {
    document.getElementById('supervisorTeamId').value = team_id;
    document.getElementById('supervisorModal').style.display = 'block';
}

function updateSupervisor() {
    let team_id = document.getElementById('supervisorTeamId').value;
    let teacher_id = document.getElementById('supervisorSelect').value;
    fetch('/team/update-supervisor', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ team_id, teacher_id })
    }).then(() => location.reload());
}

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}

document.getElementById('searchInput').addEventListener('keyup', function() {
    let val = this.value.trim();

    // اجلب كل الكروت
    const cards = document.querySelectorAll('#team-cards .card');

    cards.forEach(card => {
        const teamText = card.querySelector('.card-header span').innerText;
        if (teamText.includes(val) || val === '') {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});
</script>

@endsection