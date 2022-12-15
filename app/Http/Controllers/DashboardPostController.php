<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Storage;

class DashboardPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Post::query()
        ->with('author')
        ->when(request('search'), fn ($query, $search) =>
        $query->where('title', 'like', "%{$search}%"))
        ->latest()
        ->paginate(10)
        ->withQueryString()
        ->through(fn ($post) => [
            'id' => $post->id,
            'title' => $post->title,
            'slug' => $post->slug,
            'author' => $post->author->name,
            'created_at' => $post->created_at->diffForHumans(),
        ]);

        return Inertia::render('Dashboard/Posts/Index', [
            'posts' => $data,
            'filters' => request()->only(['search']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Dashboard/Posts/Create');
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
            'body' => ['required', 'min:10'],
        ]);

        $postImage = '';
        if ($request->file('image')) {
            $request->validate([
                'image' => ['image', 'max:1024', 'mimes:jpg,jpeg,png'],
            ]);
            $postImage = $request->file('image')->store('post-images');
        }

        Post::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'image' => $postImage,
            'body' => $request->body,
            'user_id' => auth()->user()->id,
        ]);

        return to_route('dashboard.posts.index')->with('message', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return Inertia::render('Dashboard/Posts/Show', [
            'post' => [
                'title' => $post->title,
                'body' => $post->body,
                'image' => $post->image,
                'author' => $post->author->name,
                'created_at' => $post->created_at->isoFormat('D MMM YYYY, H:mm'),
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
        return Inertia::render('Dashboard/Posts/Edit', [
            'post' => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'body' => $post->body,
                'image' => $post->image,
            ],
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
        $request->validate([
            'title' => ['required', 'max:255'],
            'body' => ['required', 'min:10'],
        ]);

        if ($request->slug !== $post->slug) {
            $request->validate([
                'slug' => ['required','max:255','alpha_dash'],
            ]);
        }

        $postImage = $post->image;
        if ($request->file('image')) {
            $request->validate([
                'image' => ['image', 'max:1024', 'mimes:jpg,jpeg,png'],
            ]);
            Storage::delete($post->image);
            $postImage = $request->file('image')->store('post-images');
        }

        $post->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'image' => $postImage,
            'body' => $request->body,
        ]);

        return to_route('dashboard.posts.index')->with('message', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // abort_if($post->user_id !== auth()->user()->id, 403, 'You are not authorized to delete this post.');

        Storage::delete($post->image);
        $post->delete();

        if ($post) {
            return redirect()->back()->with('message', 'Post deleted successfully.');
        }
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
        return response()->json(['slug' => Str::limit($slug, 30, '') . '-' . Str::random(5)]);
    }
}
