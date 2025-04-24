<?php

namespace App\Http\Controllers\Front_End\admin_super\Operations;

use App\Http\Controllers\Controller;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UniversityController extends Controller
{


    public function index()
    {


        $universities = University::all();
        $stats = [
            'total' => University::count(),
            'active' => University::where('status', 'نشط')->count(),
            'inactive' => University::where('status', 'غير نشط')->count(),
        ];


        return view('content.admin.admin_super.operations.university', compact('universities','stats'));
    }
    public function getuniversities(Request $request)
{
    $perPage = $request->input('per_page', 5);
    $query = University::query();
    $universities = $query->paginate($perPage);
    return response()->json($universities);


}


    public function store(Request $request)
    {

        $perPage = $request->input('per_page', 5);
        $query = University::query();
        $universities = $query->paginate($perPage);
        $request->validate([
            'name' => 'required',
            'number' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'status' => 'required',



        ]);

        University::create($request->all());
        return redirect()->route('universities.index');
    }

    public function edit($id)
    {
        $university = University::findOrFail($id);

        return view('content.admin.admin_super.operations.university', compact('university'));
    }

    public function update(Request $request, $id)
    {
    // تحقق من صحة البيانات المدخلة
    $request->validate([
        'name' => 'required',
        'number' => 'required',
        'phone' => 'required',
        'address' => 'required',
        'status' => 'required',
        ]);

    // استرجاع الجامعة باستخدام المعرف
    $university = University::findOrFail($id);

    // تحديث بيانات الجامعة
    $university->name = $request->input('name');
    $university->number = $request->input('number');
    $university->phone = $request->input('phone');
    $university->address = $request->input('address');
    $university->status = $request->input('status');

    // حفظ التغييرات
    $university->save();

    // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('universities.index');
    }

    public function destroy(University $university)
    {
        $university->delete();
        return redirect()->route('universities.index');
    }


}

