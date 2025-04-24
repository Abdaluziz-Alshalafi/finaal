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


 <div class="container">

    <!-- عرض الإشعارات -->
    <h2>إشعارات الطالب</h2>


    <div class="container mt-4">
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


        @foreach($modelrequest as $request)


                    <form action="{{ route('updata.stsat',$request->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf


    <div class="card mb-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">دعاك الطالب: "{{ $request->tea->student->name ?? 'غير متوفر' }}" للانضمام إلى مشروعه</h5>
            <small class="text-muted">التاريخ: {{ $request->created_at->format('d-m-Y') }}</small>
        </div>

        <div class="card-body">
            @if($request->topics->isNotEmpty())
                @foreach($request->topics as $topic)
                    <div class="border p-3 rounded mb-3">
                        <h6 class="d-flex align-items-center">
                            <i class="fas fa-bookmark text-primary me-2"></i>
                            <strong>اسم البحث:</strong> {{ $topic->sub1 ?? 'غير متوفر' }}
                        </h6>
                        <p><strong>وصف البحث:</strong> {{ $topic->describtion1 ?? 'غير متوفر' }}</p>
                    </div>

                @endforeach
                      <!-- المشرفين -->

                    <div class="border p-3 rounded mb-3">
                        <p><strong>المشرفين:</strong>
                        @php
                            $supervisors = $request->supervisors->pluck('teacher.name')->filter()->implode(', ');
                        @endphp
                        {{ $supervisors ?: 'غير متوفر' }}
                    </p>
                    </div>

            @else
                <p>لا يوجد مواضيع متاحة لهذا الطالب.</p>
            @endif
        </div>

        <div class="card-footer text-end">
            @if($request->status == 'pending')
                <span class="badge bg-warning text-dark">قيد الانتظار</span>
                <div class="mt-2">
                    <button type="button" class="btn btn-success btn-lg action-btn accept-btn" name="action" value="accepted" data-id="{{ $request->id }}">قبول</button>
                    <button type="button" class="btn btn-danger btn-lg action-btn reject-btn" data-id="{{ $request->id }}">رفض</button>
                </div>
            @elseif($request->status == 'accepted')
                <span class="badge bg-success">مقبول</span>
                <button type="button" class="btn btn-danger btn-lg action-btn reject-btn" data-id="{{ $request->id }}">رفض</button>
            @else
                <span class="badge bg-danger">لقد رفضت المشاركة في هذا المشروع</span>
            @endif
        </div>
    </div>
</form>
@endforeach


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
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






</div>


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


@endsection