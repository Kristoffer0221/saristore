<?php

namespace App\Http\Controllers;

use App\Models\PageSection;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = PageSection::orderBy('order')->get();
        return view('admin.sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sections.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'page_name' => 'required|string',
            'section_name' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:255',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        PageSection::create($validated);

        return redirect()->route('admin.sections.index')
            ->with('success', 'Section created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PageSection $section)
    {
        return view('admin.sections.edit', compact('section'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PageSection $section)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:255',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $section->update($validated);

        return redirect()->route('admin.sections.index')
            ->with('success', 'Section updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PageSection $section)
    {
        $section->delete();
        return redirect()->route('admin.sections.index')
            ->with('success', 'Section deleted successfully');
    }

    public function updateOrder(Request $request, PageSection $section)
    {
        $validated = $request->validate([
            'order' => 'required|integer|min:0'
        ]);

        $section->update(['order' => $validated['order']]);

        return response()->json(['success' => true]);
    }
}
