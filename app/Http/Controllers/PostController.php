<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        // $posts = Post::get(); //Laravel Colletion

        $posts = Post::paginate(20);

        // dd($posts);


        return view('posts.index', [
            'posts' => $posts
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


        // $request->user()->posts()->create([
        //     'body' => $request->body
        // ]);

        $request->user()->posts()->create($request->only('body'));

        return back();
    }
}
