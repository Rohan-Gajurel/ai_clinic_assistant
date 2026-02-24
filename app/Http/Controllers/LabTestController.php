<?php

namespace App\Http\Controllers;

use App\Models\LabCategory;
use App\Models\LabMethod;
use App\Models\LabSample;
use App\Models\LabTest;
use Illuminate\Http\Request;

class LabTestController extends Controller
{
    public function index()
    {
        $tests = LabTest::all();
        return view('backend.lab.test.test',compact('tests'));
    }

    public function create()
    {
        $categories = LabCategory::all();
        $methods = LabMethod::all();
        $samples = LabSample::all();
        return view('backend.lab.test.create', compact('categories', 'methods', 'samples'));
    }

    public function store(Request $request)
    {
        $data=$request->validate([
            'name' => 'required|string|max:255',
            'code'=>'nullable|string|max:255|unique:lab_tests,code',
            'category_id'=>'required|exists:lab_categories,id',
            'method_id'=>'nullable|exists:lab_methods,id',
            'sample_id'=>'nullable|exists:lab_samples,id',
            'reference_from'=>'nullable|string|max:255',
            'reference_to'=>'nullable|string|max:255',
            'unit'=>'nullable|string|max:255',
            'price'=>'required|numeric|min:0',
            'result_type'=>'required|string|max:255',
            'testable'=>'required|boolean',
            'status'=>'required|boolean',
        ]);

        LabTest::create($data);
        return redirect()->route('lab-test.index')->with('success', 'Lab test created successfully');
    }

    public function edit($id)
    {
        $test = LabTest::findOrFail($id);
        $categories = LabCategory::all();
        $methods = LabMethod::all();
        $samples = LabSample::all();
        return view('backend.lab.test.edit', compact('test', 'categories', 'methods', 'samples'));
    }

    public function update(Request $request, $id)
    {
        $test = LabTest::findOrFail($id);

        $data=$request->validate([
            'name' => 'required|string|max:255',
            'code'=>'nullable|string|max:255|unique:lab_tests,code,' . $test->id,
            'category_id'=>'required|exists:lab_categories,id',
            'method_id'=>'nullable|exists:lab_methods,id',
            'sample_id'=>'nullable|exists:lab_samples,id',
            'reference_from'=>'nullable|string|max:255',
            'reference_to'=>'nullable|string|max:255',
            'unit'=>'nullable|string|max:255',
            'price'=>'required|numeric|min:0',
            'result_type'=>'required|string|max:255',
            'testable'=>'required|boolean',
            'status'=>'required|boolean',
        ]);

        $test->update($data);
        return redirect()->route('lab-test.index')->with('updated', 'Lab test updated successfully');
    }

    public function destroy($id)
    {
        $test = LabTest::findOrFail($id);
        $test->delete();
        return redirect()->route('lab-test.index')->with('deleted', 'Lab test deleted successfully');
    }
}
