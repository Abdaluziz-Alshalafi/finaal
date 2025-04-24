<?php

namespace App\Http\Controllers\Front_End\admin_super\pags;

use App\Http\Controllers\Controller;
 use Illuminate\Support\Facades\Auth;
 use Illuminate\Http\Request;
use App\Models\Request as ModelsRequest;
use App\Models\Team;
use App\Models\Topic;
use App\Models\University;
use Illuminate\Support\Facades\Validator;


class All_UniversityController extends Controller
{

    public function index()
    {
         if (Auth::user()->role === 'superadmin') {
            $id = Auth::id(); // أو Auth::user()->id

        $team = University::all();
        return view('content.admin.admin_super.pags.All_request', compact('team'));
    }
        else{
// dd();
echo'ليس لديك صلاحيات الوصول';

   }
    }

    /**
     * إنشاء بحث جديد
     */
    public function store(Request $request)
    {
        // التحقق من البيانات
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            // 'describtion1' => 'required|string',
            // 'status' => 'required|in:pending,in-progress,completed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // إنشاء فريق بحث جديد
        // $team = new Team();
        // $team->status = $request->status;
        // $team->save();

        // إنشاء موضوع البحث
        $unver = new University();
        // $topic->team_id = $team->id;
        $unver->name = $request->name;
        // $topic->describtion1 = $request->describtion1;
        $unver->save();

        return response()->json([
            'success' => true,
            'message' => 'تم إنشاء البحث بنجاح',
            'data' => $unver->load([$unver])
        ]);
    }

    /**
     * عرض تفاصيل البحث
     */
    public function show($id)
    {
        $team = University::findOrFail($id);
        return view('content.admin.admin_super.pags.All_request', compact('team'));
    }

    /**
     * جلب بيانات البحث للتعديل
     */
    public function edit($id)
    {
        $team = University::findOrFail($id);
        return response()->json($team);
    }

    /**
     * تحديث بيانات البحث
     */
    public function update(Request $request, $id)
    {
        // التحقق من البيانات
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            // 'describtion1' => 'required|string',
            // 'status' => 'required|in:pending,in-progress,completed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // تحديث بيانات الفريق
        $team = University::findOrFail($id);
        // $team->status = $request->status;
        // $team->save();

        // تحديث موضوع البحث
        $topic = University::where('id', $id)->first();
        if (!$topic) {
            $topic = new University();
            $topic->id = $id;
        }

        $topic->name = $request->name;
        // $topic->describtion1 = $request->describtion1;

        $topic->save();

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث البحث بنجاح',
            'data' => $team->load([$team])
        ]);
    }

    /**
     * حذف البحث
     */
    public function destroy($id)
    {
        $team = University::findOrFail($id);

        // حذف المواضيع المرتبطة بالبحث
        // Topic::where('', $id)->delete();

        // حذف الفريق
        $team->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف البحث بنجاح'
        ]);
    }
}