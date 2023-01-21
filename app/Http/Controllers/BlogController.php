<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Post::search(trim(request('search')) ?? null)
        ->query(fn ($query) => $query->join('categories', 'posts.category_id', 'categories.id')
                ->join('users', 'posts.user_id', 'users.id')
                ->select(['posts.id', 'posts.title', 'posts.slug', 'posts.body', 'categories.name as category', 'users.name as author', 'posts.created_at'])
                ->orderBy('posts.created_at', 'DESC')
        )
        ->paginate(6)
        ->withQueryString()
        ->through(fn ($post) => [
            'title' => $post->title,
            'slug' => $post->slug,
            'body' => $post->body,
            'author' => $post->author,
            'category' => $post->category,
            'created_at' => $post->created_at->diffForHumans(),
        ]);

        return Inertia::render('Main/Blog/Index', [
            'posts' => $data,
            'filters' => request()->only(['search']),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return Inertia::render('Main/Blog/Detail', [
            'post' => [
                'title' => $post->title,
                'image' => $post->image,
                'body' => $post->body,
                'author' => $post->author->name,
                'category' => $post->category->name,
                'created_at' => $post->created_at->diffForHumans(),
            ],
        ]);
    }
}
