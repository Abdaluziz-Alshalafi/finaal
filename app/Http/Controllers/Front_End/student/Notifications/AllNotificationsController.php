<?php

namespace App\Http\Controllers\Front_End\student\Notifications;

use App\Http\Controllers\Controller;
use App\Jobs\DeleteTeamsAfterDelay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Request as ModelsRequest;
use App\Models\Student;
use App\Models\Team;

class AllNotificationsController extends Controller
{

    // public function index()
    // {    $currentUser = Auth::guard('students')->user();

    //     // return response()->json(['team_id' => ]);

    //     // $students = ModelsRequest::where('team_id', $team->id)
    //     // ->with('students') // جلب بيانات الطالب المرتبطة
    //     // ->get()
    //     // ->pluck('student.name');
    //     $team = Team::whereHas('requests', function ($query) use ($currentUser) {
    //         $query->where('id_student',$currentUser->id);
    //     })
    //     ->with([
    //         'students', // جلب الطلاب المرتبطين بهذا الفريق
    //         // 'requests.student',
    //         'projectSupervisors.teacher', // جلب المشرفين المرتبطين بالفريق
    //         'topics' // جلب البحوث المرتبطة بالفريق
    //     ])
    //     ->get(); // جلب فريق واحد فقط

    //     return view('content.student.pags.All_request', compact('team'));


    // }





    public function updateRequest(Request $request, $teamId, $requestId)
{
    $validated = $request->validate([
        'student_name' => 'required|string|max:255',
        'topic_name' => 'required|string|max:255',
        'supervisor_name' => 'required|string|max:255',
    ]);
    dd($validated['topic_name'].'s');

    // العثور على الطلب بناءً على teamId و requestId
    $requestModel = Request::where('team_id', $teamId)->findOrFail($requestId);

    // تحديث الطلب
    $requestModel->student()->update(['name' => $validated['student_name']]);
    $requestModel->topics()->update(['sub1' => $validated['topic_name']]);
    $requestModel->projectSupervisors()->update(['name' => $validated['supervisor_name']]);

    return redirect()->route('content.students.pags.All_request')->with('success', 'تم التعديل بنجاح!');
}

public function deleteRequest($teamId, $requestId)
{
    $requestModel = Request::where('team_id', $teamId)->findOrFail($requestId);

    dd($requestModel);
    // حذف البيانات
    // $requestModel->delete();

    return redirect()->route('content.students.pags.All_request')->with('success', 'تم الحذف بنجاح!');
}





    public function index()
    {
        $currentUser = Auth::guard('students')->user();


        $team = Team::whereHas('requests', function ($query) use ($currentUser) {
            $query->where('id_student', $currentUser->id);
        })
        ->with(['requests.student','projectSupervisors.teacher', 'topics'])
        ->get();
// dd($team);
        return view('content.students.pags.All_request', compact('team'));
    }

    // public function update(Request $request)
    // {
    //     $req = ModelsRequest::findOrFail($request->id);
    //     $req->update($request->all());
    //     return response()->json(['success' => 'تم التحديث بنجاح']);
    // }

    // public function delete(Request $request)
    // {
    //     $req = ModelsRequest::findOrFail($request->id);
    //     $req->delete();
    //     return response()->json(['success' => 'تم الحذف بنجاح']);
    // }



    public function update(Request $request, $id) {
        // منطق التعديل
    }

    public function destroy($id) {

        // منطق الحذف
    }


}
