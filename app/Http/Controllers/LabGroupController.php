<?php

namespace App\Http\Controllers;

use App\Models\LabCategory;
use App\Models\LabGroup;
use App\Models\LabTest;
use Illuminate\Http\Request;

class LabGroupController extends Controller
{
    public function index()
    {
        $groups = LabGroup::with('category', 'tests')->get();
        return view('backend.lab.group.group', compact('groups'));
    }

    public function create()
    {
        $categories = LabCategory::all();
        $tests = LabTest::all();
        return view('backend.lab.group.create', compact('categories', 'tests'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:lab_categories,id',
            'charge_amount' => 'nullable|numeric|min:0',
            'test_ids' => 'nullable|array',
            'test_ids.*' => 'exists:lab_tests,id',
        ]);

        $group = LabGroup::create($data);

        if (isset($data['test_ids'])) {
            $group->tests()->sync($data['test_ids']);
        }

        return redirect()->route('lab-group.index')->with('success', 'Lab group created successfully.');
    }

    public function edit($id)
    {
        $group = LabGroup::with('tests')->findOrFail($id);
        $categories = LabCategory::all();
        $tests = LabTest::all();
        return view('backend.lab.group.edit', compact('group', 'categories', 'tests'));
    }

    public function update(Request $request, $id)
    {
        $group = LabGroup::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:lab_categories,id',
            'charge_amount' => 'nullable|numeric|min:0',
            'test_ids' => 'nullable|array',
            'test_ids.*' => 'exists:lab_tests,id',
        ]);

        $group->update($data);
        $group->tests()->sync($data['test_ids'] ?? []);

        return redirect()->route('lab-group.index')->with('updated', 'Lab group updated successfully.');
    }

    public function destroy($id)
    {
        $group = LabGroup::findOrFail($id);
        $group->tests()->detach();
        $group->delete();

        return redirect()->route('lab-group.index')->with('deleted', 'Lab group deleted successfully.');
    }
}
