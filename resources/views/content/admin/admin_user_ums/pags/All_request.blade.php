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




{{-- <div class="container"> --}}

    {{-- <h2>طلباتي </h2> --}}


    <div class="container mt-4">






            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f7fc;
                    color: #333;
                    margin: 0;
                    padding: 0;
                }

                .container {
                    width: 90%;
                    max-width: 1200px;
                    margin: 50px auto;
                }

                .table-wrapper {
                    background: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }

                table thead {
                    background-color: #007bff;
                    color: white;
                }

                table th, table td {
                    padding: 12px;
                    text-align: center;
                    border: 1px solid #ddd;
                }

                table tr:nth-child(even) {
                    background-color: #f9f9f9;
                }



                .btn:hover {
                    background-color: #218838;
                }
            </style>


                 {{-- <form id="studentForm" action="{{ route('all.requests') }}" method="POST">
                    @csrf --}}
                     <h2>طلبات الطلاب</h2>

                     <h2>طلبات الطلاب</h2>

                     <table class="table table-hover table-bordered text-center align-middle">
                         <thead class="table-dark">
                             <tr>
                                 <th>أسماء الطلاب</th>
                                 <th>أسماء الأبحاث</th>
                                 <th>وصف الأبحاث</th>
                                 <th>أسماء المشرفين</th>
                                 <th>آخر تحديث</th>
                                 <th>الإجراءات</th>
                             </tr>
                         </thead>
                         <tbody>
                             @forelse($team as $team)
                                 <tr>
                                     <td>
                                         @foreach($team->requests as $req)
                                             <div class="border-bottom pb-1">
                                                 {{ $req->student->name ?? 'غير متوفر' }}
                                             </div>
                                         @endforeach
                                     </td>

                                     <td>
                                         @foreach($team->topics as $topic)
                                             <div class="border-bottom pb-1">
                                                 {{ $topic->sub1 ?? 'غير متوفر' }}
                                             </div>
                                         @endforeach
                                     </td>

                                     <td>
                                         @foreach($team->topics as $topic)
                                             <div class="border-bottom pb-1">
                                                 {{ $topic->describtion1 ?? 'غير متوفر' }}
                                             </div>
                                         @endforeach
                                     </td>

                                     <td>
                                         @foreach($team->projectSupervisors as $supervisor)
                                             <div class="border-bottom pb-1">
                                                 {{ $supervisor->teacher->name ?? 'غير متوفر' }}
                                             </div>
                                         @endforeach
                                     </td>

                                     <td>{{ $team->updated_at }}</td>

                                     <td>
                                         <button class="btn btn-sm btn-primary edit-request" data-id="{{ $team->id }}">
                                             <i class="fa-solid fa-edit"></i> تعديل
                                         </button>

                                         <button class="btn btn-sm btn-danger delete-request" data-id="{{ $team->id }}">
                                             <i class="fa-solid fa-trash-alt"></i> حذف
                                         </button>
                                     </td>
                                 </tr>
                             @empty
                                 <tr>
                                     <td colspan="6" class="text-center">لا توجد طلبات متاحة.</td>
                                 </tr>
                             @endforelse
                         </tbody>
                     </table>


    </div>




{{-- </form> --}}

 {{-- // $(document).ready(function () {
//     // تعديل الطلب
//     $('.edit-request').click(function () {
//         let requestId = $(this).data('id');

//         $.ajax({
//             url: `/student/requests/${requestId}/edit`,
//             type: 'GET',
//             success: function (response) {
//                 $('#editModal .modal-body').html(response);
//                 $('#editModal').modal('show');
//             },
//             error: function () {
//                 alert('حدث خطأ أثناء جلب البيانات.');
//             }
//         });
//     });
 --}}

 <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+xOJ4+Yz0tV6jyCk62I6E3UX0YPD9PEaU3F+z9Y=" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script>
    $(document).ready(function () {


    // حذف الطلب
    $('.edit-request').click(function () {
        let requestId = $(this).data('id');

        if (confirm('هل أنت متأكد أنك تريد حذف هذا الطلب؟')) {
            $.ajax({
                // url: `/student/requests/${requestId}`,
                url: "{{ route('requests.delete', ':id') }}".replace(":id", requestId),
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function (response) {
                    alert(response.message);
                    location.reload();
                },
                error: function () {
                    alert('حدث خطأ أثناء الحذف.');
                }
            });
        }
    });
});


        $('.delete-request').click(function () {
            let requestId = $(this).data("id");
            let action = $(this).hasClass("accept-btn") ? "accepted" : "rejected";

            Swal.fire({
                title: action === "accepted" ? "هل تريد قبول الدعوة؟" : "هل تريد  حذف الدعوة؟",
                text: action === "accepted" ? "إذا كان لديك مشروع، سيتم إزالته!" : "لن تتمكن من الانضمام لاحقًا.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "نعم، تابع",
                cancelButtonText: "إلغاء"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('requests.delete', ':id') }}".replace(":id", requestId),
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            action: action
                        },
                        success: function (response) {
                            Swal.fire("تم بنجاح!", response.message, "success").then(() => {
                                location.reload();
                            });
                        },
                        error: function () {
                            Swal.fire("خطأ!", "حدث خطأ أثناء تنفيذ العملية.", "error");
                        }
                    });
                }
            });
        });

































</script>



@endsection