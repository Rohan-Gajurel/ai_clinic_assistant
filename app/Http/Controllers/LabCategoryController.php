<?php

namespace App\Http\Controllers;

use App\Models\LabCategory;
use Illuminate\Http\Request;
use Pest\Plugins\Actions\CallsTerminable;

class LabCategoryController extends Controller
{
    public function index()
    {
        $categories = LabCategory::all();
        return view('backend.lab.category.category', compact('categories'));
    }

    public function create()
    {
        return view('backend.lab.category.create');
    }

    public function store(Request $request)
    {
        $data=$request->validate([
            'name'=>'required|unique:lab_categories,name',
        ]);
        LabCategory::create($data);
        return redirect()->route('lab-category.index')->with('success','Lab Category created successfully.');
    }


    public function edit($id)
    {
        $labCategory = LabCategory::findOrFail($id);
        return view('backend.lab.category.edit', compact('labCategory'));
    }

    public function update(Request $request, $id)
    {
        $labCategory = LabCategory::findOrFail($id);
        $data=$request->validate([
            'name'=>'required|unique:lab_categories,name,'.$labCategory->id,
        ]);
        $labCategory->update($data);
        return redirect()->route('lab-category.index')->with('updated','Lab Category updated successfully.');
    }

    public function destroy($id)
    {
        $labCategory = LabCategory::findOrFail($id);
        $labCategory->delete();
        return redirect()->route('lab-category.index')->with('deleted','Lab Category deleted successfully.');
    }
}
