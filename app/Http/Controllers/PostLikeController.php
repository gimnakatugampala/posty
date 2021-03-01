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
        // dd($request->user()->id);

        if ($post->likedBy($request->user())) {
            return response(null, 409); //confilt http
        }

        $post->likes()->create([
            'user_id' => $request->user()->id,
        ]);

        return back();
    }
}
