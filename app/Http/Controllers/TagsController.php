<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;

class TagsController extends BaseController
{

    public function index()
    {
        $tags = Tag::all();
        return view('tags/index', ['tags' => $tags]);
    }

    public function show(Request $request)
    {
        $tag = Tag::find($request->tag_id);
        // dd($tag->posts);
        $auth_user = Auth::user();
        return view('tags/show', ['tag' => $tag, 'auth_user' => $auth_user,]);
    }
}
