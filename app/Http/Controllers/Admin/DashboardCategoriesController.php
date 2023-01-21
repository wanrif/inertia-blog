<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::search(request('search'))
        ->query(fn ($query) => $query->withCount('posts')->orderBy('name'))
        ->paginate(5)
        ->withQueryString()
        ->through(fn ($category) => [
            'name' => $category->name,
            'slug' => $category->slug,
            'posts_count' => $category->posts_count,
            'created_at' => $category->created_at->isoFormat('dddd, D MMMM Y H:mm'),
            'updated_at' => $category->updated_at->isoFormat('dddd, D MMMM Y H:mm'),
        ]);

        return Inertia::render('Dashboard/Categories/Index', [
            'categories' => $data,
            'filters' => request()->only('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $category = Category::create([
            'name' => strtolower($request->name),
        ]);

        if ($category) {
            return back()->with('success', 'Category created successfully.');
        }

        return back()->with('error', 'Category failed to create.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$category->id,
        ]);

        $category->update([
            'name' => strtolower($request->name),
        ]);

        if ($category->wasChanged()) {
            return back()->with('success', 'Category updated successfully.');
        }

        return back()->with('error', 'Something went wrong, please try again. Or you did not change anything.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->posts->count() > 0) {
            return back()->with('error', 'Category failed to delete. Please delete all posts in this category first.');
        }

        if ($category->delete()) {
            return back()->with('success', 'Category deleted successfully.');
        }

        return back()->with('error', 'Category failed to delete.');
    }
}