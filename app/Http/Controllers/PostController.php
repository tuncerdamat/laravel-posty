<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
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

    public function destroy(Post $post)
    {
        $post->delete();
        
        return back();
    }
}
