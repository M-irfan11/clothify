<?php

namespace App\Http\Controllers;

use App\Models\categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = categories::query()
            ->orderbyDesc('created_at')
            ->paginate(15);
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $categories = categories::create($request->validate($this->rules()));

        return redirect()
            ->route('categories.show', $categories)
            ->with('success', 'Categories created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(categories $categories)
    {
        return view('categories.show', compact('categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(categories $categories)
    {
        return view('categories.edit', compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, categories $categories)
    {
        $categories->update($request->validate($this->rules($categories)));

        return redirect()
            ->route('categories.show', $categories)
            ->with('success', 'Categories updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(categories $categories)
    {
        $categories->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Categories deleted successfully.');
    }
}
