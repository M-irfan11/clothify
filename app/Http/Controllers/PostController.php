<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function index()
    {
        Gate::authorize('view posts');
        return view('posts.index', ['posts' => Post::latest()->get()]);
    }

    public function create()
    {
        Gate::authorize('create posts');
        return view('posts.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('create posts');
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
        ]);
        Post::create($data);
        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        Gate::authorize('delete posts');
        $post->delete();
        return back();
    }
}