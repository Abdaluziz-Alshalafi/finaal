<?php

namespace App\Http\Controllers\Front_End\admin_super\Operations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\depart;
use App\Models\Colls;


class departcontroller extends Controller
{
    public function index()
    {
        // $departs = depart::with('college')->get();;
        $departs = depart::all();
        $colloges = Colls::all();
        $stats = [
            'total' => depart::count(),

        ];

        return view('content.admin.admin_super.operations.depart',compact('departs','colloges','stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
        'depart_name' => 'required',
        'id_coll' => 'required',

        ]);

        depart::create($request->all());
        return redirect()->route('departs.index');
    }

    public function edit(depart $depart)
    {
        $colloges = Colls::all();
        return view('content.universities.departs.edit', compact('depart','colloges'));
    }

    public function update(Request $request, depart $depart)
    {
        $request->validate([
        'depart_name' => 'required',
        'id_coll' => 'required',


        ]);

        $depart->update($request->all());
        return redirect()->route('departs.index');
    }

    public function destroy(depart $depart)
    {
        $depart->delete();
        return redirect()->route('departs.index')->with('succecc','University deleted successfully.');
    }
}
