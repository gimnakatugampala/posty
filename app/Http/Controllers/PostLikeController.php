<?php

namespace App\Http\Controllers;

use App\Mail\PostLiked;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

        // $user = Auth::user();
        if ($post->likes()->onlyTrashed()->where('user_id', $request->user()->id->count())) {

            Mail::to($post->user)->send(new PostLiked(Auth::user(), $post));
        }

        return back();
    }

    public function destroy(Post $post, Request $request)
    {
        $request->user()->likes()->where('post_id', $post->id)->delete();

        return back();
    }
}
