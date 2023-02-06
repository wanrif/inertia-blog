<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class DashboardPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin') || auth()->user()->hasPermissionTo('manage posts')) {
            $data = Post::with(['author', 'category'])->latest()->filter(request(['search']));
        }

        if (auth()->user()->hasRole('author') && ! auth()->user()->hasPermissionTo('manage posts')) {
            $data = Post::with(['author', 'category'])->latest()->filter(request(['search']))
            ->where('user_id', auth()->user()->id);
        }

        return Inertia::render('Dashboard/Posts/Index', [
            'posts' => $data
            ->when(request('category') ?? null, fn ($query) => $query->whereHas('category', fn ($query) => $query->where('name', request('category'))))
            ->when(request('author') ?? null, fn ($query) => $query->whereHas('author', fn ($query) => $query->where('name', request('author'))))
            ->fastPaginate(5)
            ->withQueryString()
            ->through(fn ($post) => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'author' => $post->author->name,
                'category' => $post->category->name,
                'created_at' => $post->created_at->diffForHumans(),
            ]),
            'filters' => request()->only(['search', 'category', 'author']),
            'categories' => Category::all()->sortBy('name')->map(fn ($category) => [
                'name' => $category->name,
            ]),
            'authors' => User::all()->sortBy('name')->map(fn ($author) => [
                'name' => $author->name,
            ]),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Dashboard/Posts/Create', [
            'categories' => Category::all()->sortBy('name')->map(fn ($category) => [
                'id' => $category->id,
                'name' => $category->name,
            ]),
        ]);
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
            'title' => ['required', 'max:255'],
            'slug' => ['required', 'max:255', 'unique:posts,slug', 'alpha_dash'],
            'category_id' => ['required', 'exists:categories,id'],
            'body' => ['required', 'min:10'],
        ], [
            'category_id.required' => 'The category field is required.',
            'category_id.exists' => 'The selected category is invalid.',
        ]);

        $postImage = '';
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => ['image', 'max:1024', 'mimes:jpg,jpeg,png'],
            ]);
            $postImage = $request->file('image')->store('post-images');
        }

        $post = Post::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'category_id' => $request->category_id,
            'image' => $postImage,
            'body' => $request->body,
            'user_id' => auth()->user()->id,
        ]);

        if ($post) {
            return to_route('dashboard.posts.index')->with('success', 'Post created successfully.');
        }

        return to_route('dashboard.posts.index')->with('error', 'Post could not be created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        abort_if($post->user_id !== auth()->user()->id && ! auth()->user()->hasPermissionTo('manage posts'),
            403, 'You are not authorized to view this post.');

        return Inertia::render('Dashboard/Posts/Detail', [
            'post' => [
                'title' => $post->title,
                'slug' => $post->slug,
                'body' => $post->body,
                'image' => $post->image,
                'author' => $post->author->name,
                'category' => $post->category->name,
                'created_at' => $post->created_at->isoFormat('D MMM YYYY, H:mm:ss'),
                'updated_at' => $post->updated_at->isoFormat('D MMM YYYY, H:mm:ss'),
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        abort_if($post->user_id !== auth()->user()->id && ! auth()->user()->hasPermissionTo('manage posts'),
            403, 'You are not authorized to edit this post.');

        return Inertia::render('Dashboard/Posts/Edit', [
            'post' => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'category_id' => $post->category_id,
                'body' => $post->body,
                'image' => $post->image,
            ],
            'categories' => Category::all()->sortBy('name')->map(fn ($category) => [
                'id' => $category->id,
                'name' => $category->name,
            ]),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        abort_if($post->user_id !== auth()->user()->id && ! auth()->user()->hasPermissionTo('manage posts'),
            403, 'You are not authorized to update this post.');

        $request->validate([
            'title' => ['required', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'body' => ['required', 'min:10'],
        ]);

        if ($request->slug !== $post->slug) {
            $request->validate([
                'slug' => ['required', 'max:255', 'alpha_dash'],
            ]);
        }

        $postImage = '';
        if ($request->file('image')) {
            $request->validate([
                'image' => ['image', 'max:1024', 'mimes:jpg,jpeg,png'],
            ]);
            if ($post->image) {
                Storage::delete($post->image);
            }
            $postImage = $request->file('image')->store('post-images');
        }

        $post->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'category_id' => $request->category_id,
            'image' => $postImage,
            'body' => $request->body,
        ]);

        if ($post->wasChanged()) {
            return to_route('dashboard.posts.index')->with('success', 'Post updated successfully.');
        }

        return to_route('dashboard.posts.index')->with('error', 'Something went wrong, please try again. Or you did not change anything.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        abort_if($post->user_id !== auth()->user()->id && ! auth()->user()->hasPermissionTo('manage posts'),
            403, 'You are not authorized to delete this post.');

        if ($post->image) {
            Storage::delete($post->image);
        }

        if ($post->delete()) {
            return to_route('dashboard.posts.index')->with('success', 'Post deleted successfully.');
        }

        return to_route('dashboard.posts.index')->with('error', 'Post could not be deleted.');
    }

    /**
     * Get the slug for the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getSlug(Request $request)
    {
        // $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        // return response()->json(['slug' => $slug . '-' . Str::lower(Str::random(5))]);

        $slug = SlugService::createSlug(Post::class, 'slug', $request->title);

        return response()->json(['slug' => Str::limit($slug, 30, '').'-'.strtolower(Str::random(6))]);
    }
}