<?php

namespace App\Http\Controllers;

use App\Models\PageSection;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $sections = PageSection::where('page_name', 'about')
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('pages.about', compact('sections'));
    }

    public function edit($page)
    {
        $sections = PageSection::where('page_name', $page)
            ->orderBy('order')
            ->get();

        return view('admin.pages.edit', [
            'page' => $page,
            'sections' => $sections,
            'pageTitle' => ucfirst($page) . ' Page'
        ]);
    }

    public function update(Request $request, $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:255',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $section = PageSection::updateOrCreate(
            ['page_name' => $page],
            $validated
        );

        return redirect()->route('about')
            ->with('success', 'Page content updated successfully');
    }
}