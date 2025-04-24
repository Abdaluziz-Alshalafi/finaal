<?php

namespace App\Http\Controllers\Front_End\admin_super\Operations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Colls;

class Collogecontroller extends Controller
{
    public function index()
    {
        $colloges = Colls::all();
        $stats = [
            'total' => Colls::count(),
            // 'active' => University::where('status', 'نشط')->count(),
            // 'inactive' => University::where('status', 'غير نشط')->count(),
        ];
        return view('content.admin.admin_super.operations.college', compact('colloges','stats'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'coll_name' => 'required',

        ]);

        Colls::create($request->all());
        return redirect()->route('colloges.index');
    }

    public function edit(Colls $colloge)
    {
        return view('content.universities.colloges.college', compact('colloge'));
    }

    public function update(Request $request, Colls $colloge)
    {
        $request->validate([
            'coll_name' => 'required',


        ]);

        $colloge->update($request->all());
        return redirect()->route('colloges.index');
    }

    public function destroy(Colls $colloge)
    {
        $colloge->delete();
        return redirect()->route('colloges.index')->with('succecc','University deleted successfully.');
    }
}
