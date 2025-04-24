<?php

namespace App\Http\Controllers\Data\admin;

use App\Http\Controllers\Controller;
use App\Models\Research;
use App\Models\Tempresearchs;
use Illuminate\Http\Request;

class show_Temp_projectController extends Controller
{
    //
    public function store(Request $request)
    {
        $tempResearch = new Tempresearchs();

        $tempResearch->student_names = implode(',', $request->input('student_names')); // حفظ الأسماء كقائمة
        $tempResearch->research_name = $request->input('research_name');
        $tempResearch->research_description = $request->input('research_description');
        $tempResearch->save();

        return response()->json(['success' => 'Research submitted for approval']);
    }

    /**
     * Display the specified resource.
     */
    // public function show(admin $admin)
    // {
    //     //
    //     $pendingResearches = Tempresearchs::where('approved', false)->get();
    //     return view('admin.pending_researches', compact('pendingResearches'));

    // }
    public function showPendingResearches()
    {
        // استرجاع الأبحاث المعلقة


        $Tempresearchs =Tempresearchs::all();
                    return view("admin", compact("Tempresearchs"));


        // تمرير المتغير إلى View
    }

    public function approveResearch($id)
{
    $tempResearch = Tempresearchs::find($id);

    if ($tempResearch) {
        // حفظ البحث في الجدول الدائم
        Research::create([
            'id_student' =>  $tempResearch->id_student,
            'research_name' => $tempResearch->research_name,
            'research_description' => $tempResearch->research_description,
        ]);

        // إرسال إشعار للطلاب
        // يمكنك استخدام Notification أو Mail هنا

        // حذف من الجدول المؤقت
        $tempResearch->delete();

        return response()->json(['success' => 'Research approved']);
    }

    return response()->json(['error' => 'Research not found'], 404);
}

public function rejectResearch($id)
{
    $tempResearch = Tempresearchs::find($id);

    if ($tempResearch) {
        // حذف من الجدول المؤقت
        $tempResearch->delete();

        // إبلاغ الطلاب برفض البحث
        // يمكنك استخدام Notification أو Mail هنا

        return response()->json(['success' => 'Research rejected']);
    }

    return response()->json(['error' => 'Research not found'], 404);
}

public function approve($id)
{
    $research = Tempresearchs::findOrFail($id);
    $research->approved = true;
    $research->save();

    return redirect()->back()->with('success', 'Research approved successfully!');
}
public function reject($id)
{
    $research = Tempresearchs::findOrFail($id);
    $research->approved = false; // أو قم بحذفه إذا كان ذلك مناسبًا
    $research->save();

    return redirect()->back()->with('success', 'Research rejected successfully!');
}
}
