<?php

namespace App\Http\Controllers\Front_End\student\pags;

use App\Http\Controllers\Controller;
 use Illuminate\Support\Facades\Auth;
 use Illuminate\Http\Request;
use App\Models\Request as ModelsRequest;
use App\Models\Team;
use App\Models\Topic;
use Illuminate\Support\Facades\Validator;


class All_requestsController extends Controller
{

    public function index()
    {
        $id=Auth::guard('students')->user()->id;
        $team = Team::with(['topics', 'requests.student', 'projectSupervisors.teacher'])
        ->where('id_student',$id)->get();
        return view('content.students.pags.All_request', compact('team'));
    }

    /**
     * إنشاء بحث جديد
     */
    public function store(Request $request)
    {
        // التحقق من البيانات
        $validator = Validator::make($request->all(), [
            'sub1' => 'required|string|max:255',
            'describtion1' => 'required|string',
            'status' => 'required|in:pending,in-progress,completed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // إنشاء فريق بحث جديد
        $team = new Team();
        $team->status = $request->status;
        $team->save();

        // إنشاء موضوع البحث
        $topic = new Topic();
        $topic->team_id = $team->id;
        $topic->sub1 = $request->sub1;
        $topic->describtion1 = $request->describtion1;
        $topic->save();

        return response()->json([
            'success' => true,
            'message' => 'تم إنشاء البحث بنجاح',
            'data' => $team->load(['topics', 'requests.student', 'projectSupervisors.teacher'])
        ]);
    }

    /**
     * عرض تفاصيل البحث
     */
    public function show($id)
    {
        $team = Team::with(['topics', 'requests.student', 'projectSupervisors.teacher'])->findOrFail($id);
        return view('content.students.pags.research_details', compact('team'));
    }

    /**
     * جلب بيانات البحث للتعديل
     */
    public function edit($id)
    {
        $team = Team::with(['topics', 'requests.student', 'projectSupervisors.teacher'])->findOrFail($id);
        return response()->json($team);
    }

    /**
     * تحديث بيانات البحث
     */
    public function update(Request $request, $id)
    {
        // التحقق من البيانات
        $validator = Validator::make($request->all(), [
            'sub1' => 'required|string|max:255',
            'describtion1' => 'required|string',
            'status' => 'required|in:pending,in-progress,completed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // تحديث بيانات الفريق
        $team = Team::findOrFail($id);
        // $team->status = $request->status;
        // $team->save();

        // تحديث موضوع البحث
        $topic = Topic::where('team_id', $id)->first();
        if (!$topic) {
            $topic = new Topic();
            $topic->team_id = $id;
        }

        $topic->sub1 = $request->sub1;
        $topic->describtion1 = $request->describtion1;

        $topic->save();

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث البحث بنجاح',
            'data' => $team->load(['topics', 'requests.student', 'projectSupervisors.teacher'])
        ]);
    }

    /**
     * حذف البحث
     */
    public function destroy($id)
    {
        $team = Team::findOrFail($id);

        // حذف المواضيع المرتبطة بالبحث
        Topic::where('team_id', $id)->delete();

        // حذف الفريق
        $team->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف البحث بنجاح'
        ]);
    }
}