<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'])->only(['store', 'destroy']);
    }
    
    public function index()
    {
        $posts = Post::latest()->with(['user', 'likes'])->paginate(2);   // Collection
        
        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
           'body' => 'required' 
        ]);
        
        auth()->user()->posts()->create($request->only('body'));
        
        return back();
    }

    public function show(Post $post)
    {
        return view('posts.show', [
            'post' => $post,
        ]);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        
        $post->delete();
        
        return back();
    }
}
