<?php

namespace App\Http\Controllers;

use App\Mail\PostLiked;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostLikeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function store(Post $post, Request $request)
    {
        $currentUser = $request->user();
        $currentUserID = $currentUser->id;

        if ($post->likedBy($currentUser)) {
            return response(null, 409); // Conflict HTTP response
        }

        $post->likes()->create([
            'user_id' => $currentUserID,
        ]);

        if (!$post->likes()->onlyTrashed()->where('user_id', $currentUserID)->count()) {
            Mail::to($post->user)->send(new PostLiked($currentUser, $post));
        }

        return back();
    }

    // Laravel convention
    public function destroy(Post $post, Request $request)
    {
        $request->user()
            ->likes()
            ->where('post_id', $post->id)
            ->delete();

        return back();
    }
}
