<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'])->only(['store', 'destroy']);
    }
    public function index()
    {
        // $posts = Post::get(); //Laravel Colletion

        $posts = Post::orderBy('created_at', 'desc')->with('user', 'likes')->paginate(20);

        //latest()


        // dd($posts);


        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    public function show(Post $post)
    {

        return view('posts.show', [
            'post' => $post
        ]);
    }


    public function store(Request $request)
    {

        $this->validate($request, [
            'body' => 'required'
        ]);

        //    Post::create([
        //        'user_id'=> Auth::id(),
        //        'body'=>$request->body
        //    ]);

        // Auth::user()->posts()->create();


        $request->user()->posts()->create([
            'body' => $request->body
        ]);

        // $request->user()->posts()->create($request->only('body'));

        return back();
    }

    public function destroy(Post $post)
    {

        // if (!$post->ownedBy(Auth::user())) {
        //     dd('no');
        // }

        $this->authorize('delete', $post);

        $post->delete();

        return back();
    }
}
