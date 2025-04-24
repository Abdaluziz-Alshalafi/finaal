@extends('static.layouts.student')
@section('title')
Create Project
@endsection



@section('content')



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
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif


    {{-- @php


    $showButton = false; // افتراضيًا، الزر مخفي

    foreach ($modelrequest as $allstudent) {
        $statu = $allstudent->team_id;

        $stat=$allstudent->where('team_id',$statu)
        ->where('student_id','!=',Auth::guard('students')->user()->id)->get();


        $statuses=$stat->pluck('status')->toArray();
// dd($statuses);


        if (in_array('rejected', $statuses) || in_array('pending', $statuses)) {
            $showButton = true; // يوجد طلاب لم يتم قبولهم بعد، أظهر الزر
            break;
        }
    }

        @endphp --}}

        <div class="container py-4" style="direction: rtl;">
            @foreach($modelrequest as $request)
                <form action="{{ route('updata.stsat', $request->id) }}" method="POST" enctype="multipart/form-data" class="mb-4">
                    @csrf

                    <div class="card shadow-sm border rounded-4 overflow-hidden">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-primary fw-semibold">
                                <i class="bi bi-person-fill-check me-2"></i>
                                دعاك الطالب: "{{ $request->tea->student->name ?? 'غير متوفر' }}" للانضمام إلى مشروعه
                            </h5>
                            <small class="text-muted"><i class="bi bi-calendar3 me-1"></i> {{ $request->created_at->format('d-m-Y') }}</small>
                        </div>

                        <div class="card-body bg-white">
                            @if($request->topics->isNotEmpty())
                                @foreach($request->topics as $topic)
                                    <div class="border rounded-3 p-3 mb-3 bg-light">
                                        <h6 class="text-info fw-bold mb-2">
                                            <i class="bi bi-journal-text me-1"></i> اسم البحث:
                                            <span class="text-dark">{{ $topic->sub1 ?? 'غير متوفر' }}</span>
                                        </h6>
                                        <p class="mb-0"><strong>وصف البحث:</strong> {{ $topic->describtion1 ?? 'غير متوفر' }}</p>
                                    </div>
                                @endforeach

                                <div class="border rounded-3 p-3 bg-light">
                                    <p class="mb-0"><strong>المشرفين:</strong>
                                        @php
                                            $supervisors = $request->supervisors->pluck('teacher.name')->filter()->implode(', ');
                                        @endphp
                                        {{ $supervisors ?: 'غير متوفر' }}
                                    </p>
                                </div>
                            @else
                                <div class="alert alert-warning text-center">لا يوجد مواضيع متاحة لهذا الطالب.</div>
                            @endif
                        </div>

                        <div class="card-footer bg-light d-flex flex-column align-items-end">
                            @if($request->status == 'pending')
                                <span class="badge bg-warning text-dark mb-2 px-3 py-2">قيد الانتظار</span>
                                <div>
                                    <button type="button" class="btn btn-success rounded-pill px-4 me-2 action-btn accept-btn"
                                            name="action" value="accepted" data-id="{{ $request->id }}">
                                        <i class="bi bi-check-circle-fill me-1"></i> قبول
                                    </button>

                                    <button type="button" class="btn btn-outline-danger rounded-pill px-4 action-btn reject-btn"
                                            data-id="{{ $request->id }}">
                                        <i class="bi bi-x-circle-fill me-1"></i> رفض
                                    </button>
                                </div>
                            @elseif($request->status == 'accepted')
                                <span class="badge bg-success mb-2 px-3 py-2">مقبول</span>
                                <button type="button" class="btn btn-outline-danger rounded-pill px-4 action-btn reject-btn"
                                        data-id="{{ $request->id }}">
                                    <i class="bi bi-x-circle-fill me-1"></i> رفض
                                </button>
                            @else
                                <span class="badge bg-danger px-3 py-2">لقد رفضت المشاركة في هذا المشروع</span>
                            @endif
                        </div>
                    </div>
                </form>
            @endforeach
        </div>


@endsection
<script  src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    $(document).ready(function () {
        $(".accept-btn, .reject-btn").click(function () {
            let requestId = $(this).data("id");
            let action = $(this).hasClass("accept-btn") ? "accepted" : "rejected";

                        Swal.fire({
                title: action === "accepted" ? "هل تريد قبول الدعوة؟" : "هل تريد رفض الدعوة؟",
                text: action === "accepted" ? "إذا كان لديك مشروع، سيتم إزالته!" : "لن تتمكن من الانضمام لاحقًا.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "نعم، تابع",
                cancelButtonText: "إلغاء"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('updata.stsat', ':id') }}".replace(":id", requestId),
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            action: action
                        },
                        success: function (response) {
                            // ✅ عرض الرسالة القادمة من Laravel داخل SweetAlert2
                            Swal.fire({
                                icon: 'success',
                                title: 'تم بنجاح!',
                                text: response.message
                            }).then(() => {
                                location.reload(); // إعادة تحميل الصفحة
                            });
                        },
                        error: function () {
                            Swal.fire("خطأ!", "حدث خطأ أثناء تنفيذ العملية.", "error");
                        }
                    });
                }
            });
        });
    });
</script>


    <!-- إضافة أيقونات FontAwesome -->









{{-- @vite([

'resources/site/js/jquery-3.6.0.min.js',
]); --}}

{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
{{--
<script>



    $(document).ready(function () {
        $(".action-btn").click(function () {
            let requestId = $(this).data("id");
            let status = $(this).data("status");
            let button = $(this);
            let s = 0;
            $.ajax({
            url: "{{ route('requests.update_request_status') }}",
                type: 'POST',
                data: {
                    id: requestId,
                    status: status,
                    _token: '{{ csrf_token() }}' // إضافة رمز CSRF
                },


                success: function (response) {
                    if (response.success) {
                        alert(response.message);
                        if (status === "accepted") {
                            // إخفاء جميع الطلبات الأخرى لنفس الطالب
                            $(".request-card[data-student='" + response.student_id + "']").remove();
                            $("#row-" + requestId).show(); // فقط الطلب المقبول يبقى
                        } else {
                            // إخفاء الطلب المرفوض فقط
                            $("#row-" + requestId).remove();
                        }
                    } else {
                        alert("حدث خطأ أثناء تنفيذ العملية");
                    }
                },
            error: function (xhr, status, error) {
    console.error(xhr.responseText); // يعرض تفاصيل الخطأ في المتصفح
    alert("فشل الاتصال بالخادم");
}
            });
        });
    });
</script> --}}







{{-- <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> --}}


