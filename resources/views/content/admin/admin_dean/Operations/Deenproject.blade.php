
@extends('static.layouts.admin')

@section('title')
Dashboard
@endsection


<style>

:root {
    --primary-color: #3498db;
    --secondary-color: #2c3e50;
    --accent-color: #e74c3c;
    --success-color: #2ecc71;
    --light-color: #ecf0f1;
    --dark-color: #34495e;
}

body {
    font-family: 'Tajawal', sans-serif;
    direction: rtl;
    text-align: right;
    background-color: #f5f7fa;
    color: #333;
    line-height: 1.6;
}

.header {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    padding: 25px;
    text-align: center;
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 30px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
}

.header::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.3));
    z-index: 1;
}

.container {
    max-width: 1200px;
    margin: 0 auto 50px;
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
}

.project-card {
    border: none;
    padding: 25px;
    border-radius: 12px;
    background: #fff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    margin-bottom: 30px;
    border-left: 4px solid var(--primary-color);
}

.project-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
}

.team-info {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.team-info p {
    margin-bottom: 8px;
}

.team-info strong {
    color: var(--secondary-color);
}

.project-title {
    color: var(--secondary-color);
    font-weight: 700;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
}

.project-title i {
    margin-left: 10px;
    color: var(--primary-color);
}

.title-card {
    border: 1px solid #e0e0e0;
    padding: 15px;
    border-radius: 8px;
    background: #f8fafc;
    margin-bottom: 15px;
    transition: all 0.3s ease;
}

.title-card:hover {
    background: #f1f5f9;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.title-card h6 {
    color: var(--dark-color);
    font-weight: 600;
    margin-bottom: 10px;
}

.action-buttons {
    display: flex;
    gap: 8px;
    justify-content: center;
}

.btn {
    padding: 8px 15px;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.2s;
    border: none;
    cursor: pointer;
    font-size: 14px;
}

.btn i {
    margin-left: 5px;
}

.btn-accept {
    background-color: var(--success-color);
    color: white;
}

.btn-reject {
    background-color: var(--accent-color);
    color: white;
}

.btn-description {
    background-color: var(--secondary-color);
    color: white;
}

.description {
    display: none;
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    margin-top: 10px;
    border-right: 3px solid var(--primary-color);
}

.description p {
    margin-bottom: 0;
    line-height: 1.7;
}

.stats-buttons {
    display: flex;
    justify-content: space-between;
    margin-bottom: 30px;
}

.stats-btn {
    width: 48%;
    padding: 12px;
    font-size: 16px;
    font-weight: 600;
}

.badge {
    border-radius: 50px;
    padding: 5px 12px;
    background-color: var(--primary-color);
    color: white;
    font-weight: bold;
    font-size: 14px;
    margin-right: 5px;
}

/* Notification Styles */
.notification {
    display: none;
    position: fixed;
    top: 30px;
    right: 30px;
    padding: 15px 25px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 500;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    z-index: 1000;
    animation: slideIn 0.3s ease;
    color: white;
}

.notification.success {
    background-color: var(--success-color);
}

.notification.error {
    background-color: var(--accent-color);
}

.notification.info {
    background-color: var(--primary-color);
}

@keyframes slideIn {
    from { transform: translateY(-30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.notification.show {
    display: block;
}

/* Modal Styles */
.modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 999;
    justify-content: center;
    align-items: center;
}

.modal-content {
    background-color: white;
    padding: 25px;
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    animation: modalFadeIn 0.3s ease;
}

@keyframes modalFadeIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}

.modal-title {
    font-size: 20px;
    font-weight: 700;
    color: var(--secondary-color);
    margin: 0;
}

.modal-close {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #777;
    transition: color 0.3s;
}

.modal-close:hover {
    color: var(--accent-color);
}

.modal-body {
    margin-bottom: 20px;
    line-height: 1.7;
}

.modal-footer {
    text-align: left;
}
body { font-family: Arial; direction: rtl; padding: 20px; }
.tab { display: none; }
.tab.active { display: block; }
.tabs { margin-bottom: 20px; }
.tabs button { margin-left: 10px; padding: 10px; cursor: pointer; }
.team-box { border: 1px solid #ccc; margin-bottom: 20px; padding: 10px; border-radius: 10px; }
.project { background: #f9f9f9; padding: 10px; margin: 10px 0; border-radius: 5px; }
.btn { padding: 5px 10px; margin: 5px; cursor: pointer; border: none; border-radius: 5px; }
.btn-accept { background-color: #4CAF50; color: white; }
.btn-reject { background-color: #f44336; color: white; }
.btn-revert { background-color: #2196F3; color: white; }

.hidden { display: none; }
 .swal2-border-radius {
        border-radius: 15px !important;
        font-family: 'Tajawal', sans-serif;
    }
    .swal2-title-custom {
        font-size: 22px;
        color: #2c3e50;
    }
    .swal2-button-custom {
        background-color: #3498db !important;
        color: white !important;
        font-weight: bold;
    }
    .swal2-arabic .swal2-title {
    color: #d33;
    font-weight: 700;
}

.swal2-arabic .swal2-input {
    text-align: right;
    direction: rtl;
    min-height: 100px;
}

.swal2-arabic .swal2-actions {
    justify-content: flex-start;
    gap: 10px;
}
</style>

 @section('content')

<div class="container">
<div class="stats-buttons">
    <button onclick="showTab('pending')" class="btn btn-secondary stats-btn"><i class="fas fa-spinner fa-spin"></i>قيد المراجعة</button>
    <button onclick="showTab('accepted')" class="btn btn-secondary stats-btn"><i class="fas fa-check-circle"></i>مقبولة</button>
    <button onclick="showTab('rejected')" class="btn btn-secondary stats-btn"><i class="fas fa-times-circle"></i>مرفوضة</button>
</div>

<!-- تبويب قيد المراجعة -->
<!-- تبويب قيد المراجعة -->
<div id="pending" class="tab active">
@foreach($topics as $team_id => $teamTopics)
    @php
        $requests = App\Models\Request::where('team_id', $team_id)->get();
        $allAccepted = $requests->every(fn($r) => $r->status == 'accepted');
    @endphp
    @if($allAccepted)
        <div class="project-card">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="project-title m-0">
                    <i class="fas fa-project-diagram"></i><h5>الفريق رقم: {{ $team_id }}</h5>
                </h5>

                <button onclick="toggleProjects({{ $team_id }})" class="btn btn-secondary">
                    <i class="fas fa-chevron-down"></i> عرض التفاصيل
                </button>
            </div>

            <div id="projects-{{ $team_id }}" class="hidden">
                <p><strong><i class="fas fa-user-tie"></i> المشرفين:</strong>
                    {{ App\Models\Project_supervisors::where('team_id', $team_id)->get()->pluck('teacher.name')->join(', ') }}
                </p>

                <p><strong><i class="fas fa-users"></i> أعضاء الفريق:</strong>
                    {{ $requests->pluck('student.name')->join(', ') }}
                </p>

                <h6 class="text-center mb-3" style="color: var(--secondary-color); font-weight: 600;">
                    <i class="fas fa-lightbulb"></i> العناوين المقترحة
                </h6>

                @foreach($teamTopics as $topic)
                    <div class="title-card"><strong>عنوان المشروع:</strong><h6>{{ $topic->sub1 }}</h6>
                        <div class="action-buttons" id="project-{{ $topic->id }}">

                            <button class="btn btn-accept" onclick="acceptProject({{ $topic->id }})">
                                <i class="fas fa-check"></i> قبول
                            </button>
                            <button class="btn btn-reject" onclick="rejectProject({{ $topic->id }}, {{ $teamTopics->count() }})">
                                <i class="fas fa-times"></i> رفض
                            </button>
                            <button class="btn btn-description" onclick="showDescription('{{ $topic->describtion1 }}')">
                                <i class="fas fa-info-circle"></i> وصف
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endforeach
</div>
<!-- تبويب المقبولة -->
<div id="accepted" class="tab">
    @foreach($acceptedTopics as $team_id => $topics)
        <div class="team-box">
            <h3>الفريق رقم: {{ $team_id }}</h3>
            @foreach($topics as $topic)
                <div class="project"><strong>عنوان المشروع:</strong>{{ $topic->sub1 }}<button class="btn btn-description" onclick="showDescription('{{ $topic->describtion1 }}')">
                                <i class="fas fa-info-circle"></i> وصف
                            </button></div>
            @endforeach
        </div>
    @endforeach
</div>

<!-- تبويب المرفوضة -->
<div id="rejected" class="tab">
    @foreach($rejectedTopics as $team_id => $topics)
        <div class="team-box">
            <h3>الفريق رقم: {{ $team_id }}</h3>
            @foreach($topics as $topic)
                <div class="project">
                <strong>عنوان المشروع:</strong>  {{ $topic->sub1 }}<button class="btn btn-description" onclick="showDescription('{{ $topic->describtion1 }}')">
                                <i class="fas fa-info-circle"></i> وصف
                            </button>
                    <button class="btn btn-revert" onclick="revertProject({{ $topic->id }})">تراجع</button>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
</div>


<script>
function showTab(id) {
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    document.getElementById(id).classList.add('active');
}

function toggleProjects(team_id) {
    const el = document.getElementById('projects-' + team_id);
    el.classList.toggle('hidden');

}

function acceptProject(id) {
    fetch('/dean/projects/accept', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'accept': 'application/json'
        },
        body: JSON.stringify({ id })
    }).then(res => res.json()).then(data => {
        if (data.success) location.reload();
    });
}

function rejectProject(id, count) {
if (count === 1) {
    Swal.fire({
        title: 'سبب الرفض',
        input: 'textarea',
        inputPlaceholder: 'اكتب سبب الرفض هنا...',
        showCancelButton: true,
        confirmButtonText: 'رفض',
        cancelButtonText: 'إلغاء',
        confirmButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed && result.value) {
            sendReject(id, result.value);
        }
    });
} else {
    sendReject(id);
}
}

function sendReject(id, reason = null) {
    fetch('/dean/projects/reject', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id, reason })
    }).then(res => res.json()).then(data => {
        if (data.rejected) location.reload();
    });
}

function revertProject(id) {
    fetch('/dean/projects/revert', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'

        },
        body: JSON.stringify({ id })
    }).then(res => res.json()).then(data => {
        if (data.reverted) location.reload();
    });
}
</script>
<script>
function showDescription(description) {
    Swal.fire({
        title: 'وصف المشروع',
        text: description,
        icon: 'info',
        confirmButtonText: 'حسنًا',
        customClass: {
            popup: 'swal2-border-radius',
            title: 'swal2-title-custom',
            confirmButton: 'swal2-button-custom'
        }
    });
}

</script>
</style>
@endsection