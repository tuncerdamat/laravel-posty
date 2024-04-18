<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function store(Post $post, Request $request)
    {
        $currentUser = $request->user();
        if ($post->likedBy($currentUser)) {
            return response(null, 409); // Conflict HTTP response
        }

        $post->likes()->create([
            'user_id' => $currentUser->id,
        ]);

        return back();
    }
}
