<?php

namespace App\Http\Controllers;

use App\Models\LabMethod;
use Illuminate\Http\Request;

class LabMethodController extends Controller
{
    public function index()
    { 
        $methods = LabMethod::all();
        return view('backend.lab.method.method', compact('methods'));
    }

    public function create()
    {
        return view('backend.lab.method.create');
    }

    public function store(Request $request)
    {
        $data=$request->validate([
            'name' => 'required|string|max:255',
            'code'=>'nullable|string|max:255|unique:lab_methods,code',
        ]);

        if(!$request->filled('code')){
            $data['code'] = 'LM-' . strtoupper(substr($request->name, 0, 3));
        }
        LabMethod::create($data);
        return redirect()->route('lab-method.index')->with('success', 'Lab method created successfully.');
    }

    public function edit($id)
    {
        $method = LabMethod::findOrFail($id);
        return view('backend.lab.method.edit', compact('method'));
    }

    public function update(Request $request, $id)
    {
        $method = LabMethod::findOrFail($id);

        $data=$request->validate([
            'name' => 'required|string|max:255',
            'code'=>'nullable|string|max:255|unique:lab_methods,code,' . $method->id,
        ]);

        if(!$request->filled('code')){
            $data['code'] = 'LM-' . strtoupper(substr($request->name, 0, 3));
        }

        $method->update($data);
        return redirect()->route('lab-method.index')->with('updated', 'Lab method updated successfully.');
    }

    public function destroy($id)
    {
        $method = LabMethod::findOrFail($id);
        $method->delete();
        return redirect()->route('lab-method.index')->with('deleted', 'Lab method deleted successfully.');
    }
}
