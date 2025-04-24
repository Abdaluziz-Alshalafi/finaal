<?php

namespace App\Http\Controllers\Front_End\admin_super\Operations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 use App\Models\University;
use App\Models\depart;
use App\Models\uni_depart;

class uni_departcontroller extends Controller
{
    public function index()
    {
        $uni_departs =uni_depart::all();

        $universities =University::all();
        $departs = depart::all();
        // dd($universities);
        $stats = [
            'total' => uni_depart::count(),
            'active' => uni_depart::where('status', 'نشط')->count(),
            'inactive' => uni_depart::where('status', 'غير نشط')->count(),
        ];
        return view('content.admin.admin_super.operations.uni_depart', compact('universities', 'departs','uni_departs','stats'));
    }
    // public function create() {
    //     $universities =University::all();
    //     $departs = depart::all();
    //      return view('content.admin.admin_super.operations.uni_depart', compact('universities', 'departs'));
    // }

    public function store(Request $request) {
        $request->validate(['id_uni' => 'required', 'id_depart' => 'required','status'=>'required']);
        uni_depart::create($request->all());
         return redirect()->route('uni_departs.index');

}
public function edit($id)
    {
        $uni_depart = uni_depart::findOrFail($id);

        return view('content.admin.admin_super.operations.uni_depart', compact('uni_depart'));
    }

    public function update(Request $request, $id)
    {
    // تحقق من صحة البيانات المدخلة
    $request->validate([
        'id_uni' => 'required',
        'id_depart' => 'required',
        'status' => 'required',
        ]);

    // استرجاع الجامعة باستخدام المعرف
    $uni_depart = uni_depart::findOrFail($id);

    // تحديث بيانات الجامعة
    $uni_depart->id_uni = $request->input('id_uni');
    $uni_depart->id_depart = $request->input('id_depart');
    $uni_depart->status = $request->input('status');

    // حفظ التغييرات
    $uni_depart->save();

    // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('uni_departs.index');

}
}

