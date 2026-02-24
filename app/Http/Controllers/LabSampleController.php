<?php

namespace App\Http\Controllers;

use App\Models\LabSample;
use Illuminate\Http\Request;

class LabSampleController extends Controller
{
    public function index()
    {
       $samples = LabSample::all();
       return view('backend.lab.sample.sample', compact('samples'));
    }

    public function create()
    {
        return view('backend.lab.sample.create');
    }

    public function store(Request $request)
    {
        
        $data=$request->validate([
            'name' => 'required|string|max:255',
            'code'=>'nullable|string|max:255|unique:lab_samples,code',
        ]);

        if(!$request->filled('code')){
            $data['code'] = 'LS-' . strtoupper(substr($request->name, 0, 3));
        }
        LabSample::create($data);
        return redirect()->route('lab-sample.index')->with('success', 'Lab sample created successfully.');
    }



    public function edit($id)
    {
        $sample = LabSample::findOrFail($id);
        return view('backend.lab.sample.edit', compact('sample'));
    }

    public function update(Request $request, $id)
    {
        $sample = LabSample::findOrFail($id);

        $data=$request->validate([
            'name' => 'required|string|max:255',
            'code'=>'nullable|string|max:255|unique:lab_samples,code,' . $sample->id,
        ]);

        if(!$request->filled('code')){
            $data['code'] = 'LS-' . strtoupper(substr($request->name, 0, 3));
        }

        $sample->update($data);
        return redirect()->route('lab-sample.index')->with('updated', 'Lab sample updated successfully.');
    }

    public function destroy($id)
    {
        $sample = LabSample::findOrFail($id);
        $sample->delete();
        return redirect()->route('lab-sample.index')->with('deleted', 'Lab sample deleted successfully.');
    }
}
