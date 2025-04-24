@extends('static.layouts.student')


@section('content')
<div class="research-details-page">
    <!-- شريط التنقل العلوي -->
    <div class="details-navbar">
        <a href="{{ route('research.index') }}" class="back-button">
            <i class="fas fa-arrow-right"></i>
            <span>العودة للقائمة</span>
        </a>
        <div class="navbar-actions">
            <button class="action-button print-button" onclick="window.print()">
                <i class="fas fa-print"></i>
                <span>طباعة</span>
            </button>
            <button class="action-button share-button" onclick="shareResearch()">
                <i class="fas fa-share-alt"></i>
                <span>مشاركة</span>
            </button>
        </div>
    </div>

    <!-- قسم العنوان الرئيسي -->
    <div class="research-hero-section">
        <div class="research-status-indicator">
            @php
                $statusClass = '';
                $statusText = 'قيد المراجعة';
                $statusIcon = 'hourglass-half';

                switch($team->status ?? 'pending') {
                    case 'completed':
                        $statusClass = 'completed';
                        $statusText = 'مكتمل';
                        $statusIcon = 'check-circle';
                        break;
                    case 'in-progress':
                        $statusClass = 'in-progress';
                        $statusText = 'قيد التنفيذ';
                        $statusIcon = 'clock';
                        break;
                }
            @endphp
            <div class="status-badge {{ $statusClass }}">
                <i class="fas fa-{{ $statusIcon }}"></i>
                <span>{{ $statusText }}</span>
            </div>
        </div>

        <h1 class="research-main-title">
            @if($team->topics->count() > 1)
                مشروع بحثي متعدد ({{ $team->topics->count() }} أبحاث)
            @else
                {{ $team->topics->first()->sub1 ?? 'لا يوجد عنوان' }}
            @endif
        </h1>

        <div class="research-meta-info">
            <div class="meta-item">
                <i class="fas fa-calendar-alt"></i>
                <span>تاريخ البدء: {{ $team->created_at ? $team->created_at->format('d M Y') : 'غير محدد' }}</span>
            </div>
            <div class="meta-item">
                <i class="fas fa-clock"></i>
                <span>آخر تحديث: {{ $team->updated_at ? $team->updated_at->format('d M Y') : 'غير محدد' }}</span>
            </div>
            <div class="meta-item">
                <i class="fas fa-users"></i>
                <span>عدد الطلاب: {{ $team->requests->count() }}</span>
            </div>
            <div class="meta-item">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>عدد المشرفين: {{ $team->projectSupervisors->count() }}</span>
            </div>
        </div>
    </div>

    <!-- قسم الأبحاث -->
    <div class="research-topics-section">
        @foreach($team->topics as $index => $topic)
            <div class="research-topic-card">
                <div class="topic-number">{{ $index + 1 }}</div>
                <div class="topic-content">
                    <h2 class="topic-title">{{ $topic->sub1 }}</h2>
                    <p class="topic-description">{{ $topic->describtion1 }}</p>

                    @if($topic->keywords)
                        <div class="topic-keywords">
                            @foreach(explode(',', $topic->keywords) as $keyword)
                                <span class="keyword-badge">{{ trim($keyword) }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- قسم الطلاب والمشرفين -->
    <div class="people-section">
        <!-- قسم الطلاب -->
        <div class="people-card students-card">
            <div class="card-header">
                <div class="header-icon student-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h2>الطلاب المشاركين</h2>
                <div class="counter-badge">{{ $team->requests->count() }}</div>
            </div>
            <div class="card-body">
                @if($team->requests->isNotEmpty())
                    <div class="people-grid">
                        @foreach($team->requests as $request)
                            <div class="person-card student-card">
                                <div class="person-avatar">
                                    {{ substr($request->student->name ?? 'غ', 0, 1) }}
                                </div>
                                <div class="person-details">
                                    <h3 class="person-name">{{ $request->student->name ?? 'غير معروف' }}</h3>
                                    <div class="person-id">{{ $request->student->student_id ?? 'غير معروف' }}</div>
                                    <div class="person-contact">
                                        <i class="fas fa-envelope"></i>
                                        <span>{{ $request->student->email ?? 'غير متوفر' }}</span>
                                    </div>
                                    <div class="person-date">
                                        <i class="fas fa-calendar-plus"></i>
                                        <span>{{ $request->created_at ? $request->created_at->format('d M Y') : 'غير محدد' }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-illustration">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h3>لا يوجد طلاب</h3>
                        <p>لم يتم إضافة أي طلاب لهذا البحث بعد.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- قسم المشرفين -->
        <div class="people-card supervisors-card">
            <div class="card-header">
                <div class="header-icon supervisor-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <h2>المشرفين على البحث</h2>
                <div class="counter-badge">{{ $team->projectSupervisors->count() }}</div>
            </div>
            <div class="card-body">
                @if($team->projectSupervisors->isNotEmpty())
                    <div class="people-grid">
                        @foreach($team->projectSupervisors as $supervisor)
                            <div class="person-card supervisor-card">
                                <div class="person-avatar supervisor">
                                    {{ substr($supervisor->teacher->name ?? 'غ', 0, 1) }}
                                </div>
                                <div class="person-details">
                                    <h3 class="person-name">{{ $supervisor->teacher->name ?? 'غير معروف' }}</h3>
                                    <div class="person-position">{{ $supervisor->teacher->position ?? 'غير معروف' }}</div>
                                    <div class="person-contact">
                                        <i class="fas fa-envelope"></i>
                                        <span>{{ $supervisor->teacher->email ?? 'غير متوفر' }}</span>
                                    </div>
                                    <div class="person-date">
                                        <i class="fas fa-calendar-plus"></i>
                                        <span>{{ $supervisor->created_at ? $supervisor->created_at->format('d M Y') : 'غير محدد' }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-illustration">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <h3>لا يوجد مشرفين</h3>
                        <p>لم يتم إضافة أي مشرفين لهذا البحث بعد.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- قسم المرفقات والملفات -->
    <div class="attachments-section">
        <div class="section-header">
            <div class="header-icon">
                <i class="fas fa-paperclip"></i>
            </div>
            <h2>المرفقات والملفات</h2>
        </div>
        <div class="section-body">
            <div class="empty-state">
                <div class="empty-illustration">
                    <i class="fas fa-file-alt"></i>
                </div>
                <h3>لا توجد ملفات</h3>
                <p>لم يتم إضافة أي ملفات لهذا البحث بعد.</p>
            </div>
        </div>
    </div>

    <!-- قسم التعليقات -->
    <div class="comments-section">
        <div class="section-header">
            <div class="header-icon">
                <i class="fas fa-comments"></i>
            </div>
            <h2>التعليقات والملاحظات</h2>
        </div>
        <div class="section-body">
            <div class="empty-state">
                <div class="empty-illustration">
                    <i class="fas fa-comments"></i>
                </div>
                <h3>لا توجد تعليقات</h3>
                <p>لم يتم إضافة أي تعليقات لهذا البحث بعد.</p>
            </div>
        </div>
    </div>

    <!-- قسم المراحل الزمنية -->
    <div class="timeline-section">
        <div class="section-header">
            <div class="header-icon">
                <i class="fas fa-history"></i>
            </div>
            <h2>المراحل الزمنية للبحث</h2>
        </div>
        <div class="section-body">
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-point"></div>
                    <div class="timeline-content">
                        <div class="timeline-date">{{ $team->created_at ? $team->created_at->format('d M Y') : 'غير محدد' }}</div>
                        <h3 class="timeline-title">بدء البحث</h3>
                        <p class="timeline-description">تم إنشاء البحث وبدء العمل عليه</p>
                    </div>
                </div>

                @if($team->status == 'in-progress')
                <div class="timeline-item">
                    <div class="timeline-point"></div>
                    <div class="timeline-content">
                        <div class="timeline-date">{{ $team->updated_at ? $team->updated_at->format('d M Y') : 'غير محدد' }}</div>
                        <h3 class="timeline-title">بدء التنفيذ</h3>
                        <p class="timeline-description">تم البدء في تنفيذ البحث</p>
                    </div>
                </div>
                @endif

                @if($team->status == 'completed')
                <div class="timeline-item">
                    <div class="timeline-point"></div>
                    <div class="timeline-content">
                        <div class="timeline-date">{{ $team->updated_at ? $team->updated_at->format('d M Y') : 'غير محدد' }}</div>
                        <h3 class="timeline-title">اكتمال البحث</h3>
                        <p class="timeline-description">تم الانتهاء من البحث بنجاح</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- نافذة مشاركة البحث -->
    <div class="modal" id="shareModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>مشاركة البحث</h3>
                <button class="close-button" onclick="closeShareModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>يمكنك مشاركة هذا البحث من خلال الرابط التالي:</p>
                <div class="share-link-container">
                    <input type="text" id="shareLink" value="{{ route('research.show', $team->id) }}" readonly>
                    <button class="copy-button" onclick="copyShareLink()">
                        <i class="fas fa-copy"></i>
                        نسخ
                    </button>
                </div>
                <div class="share-options">
                    <a href="https://wa.me/?text={{ urlencode('مشاركة بحث: ' . ($team->topics->count() > 1 ? 'مشروع بحثي متعدد' : $team->topics->first()->sub1 ?? 'بحث') . ' - ' . route('research.show', $team->id)) }}" class="share-option whatsapp" target="_blank">
                        <i class="fab fa-whatsapp"></i>
                        واتساب
                    </a>
                    <a href="https://t.me/share/url?url={{ urlencode(route('research.show', $team->id)) }}&text={{ urlencode('مشاركة بحث: ' . ($team->topics->count() > 1 ? 'مشروع بحثي متعدد' : $team->topics->first()->sub1 ?? 'بحث')) }}" class="share-option telegram" target="_blank">
                        <i class="fab fa-telegram"></i>
                        تيليجرام
                    </a>
                    <a href="mailto:?subject={{ urlencode('مشاركة بحث: ' . ($team->topics->count() > 1 ? 'مشروع بحثي متعدد' : $team->topics->first()->sub1 ?? 'بحث')) }}&body={{ urlencode('يمكنك الاطلاع على البحث من خلال الرابط التالي: ' . route('research.show', $team->id)) }}" class="share-option email">
                        <i class="fas fa-envelope"></i>
                        البريد الإلكتروني
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- رسالة تم النسخ -->
    <div class="toast" id="copyToast">
        <div class="toast-icon">
            <i class="fas fa-check"></i>
        </div>
        <div class="toast-message">تم نسخ الرابط بنجاح!</div>
    </div>
</div>
<style>

    </style>
    @endsection




<script>
document.addEventListener('DOMContentLoaded', function() {
    // مشاركة البحث
    window.shareResearch = function() {
        document.getElementById('shareModal').style.display = 'flex';
    };

    // إغلاق نافذة المشاركة
    window.closeShareModal = function() {
        document.getElementById('shareModal').style.display = 'none';
    };

    // نسخ رابط المشاركة
    window.copyShareLink = function() {
        const shareLink = document.getElementById('shareLink');
        shareLink.select();
        document.execCommand('copy');

        // إظهار رسالة النسخ
        const toast = document.getElementById('copyToast');
        toast.classList.add('show');

        // إخفاء الرسالة بعد 3 ثوانٍ
        setTimeout(function() {
            toast.classList.remove('show');
        }, 3000);
    };

    // إغلاق النافذة عند النقر خارجها
    window.onclick = function(event) {
        const modal = document.getElementById('shareModal');
        if (event.target == modal) {
            closeShareModal();
        }
    };
});
</script>
