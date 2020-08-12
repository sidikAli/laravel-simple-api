<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
Use App\Post;
Use Validator;

class PostController extends Controller
{
    public function index()
    {
    	$posts = Post::all();
    	return response()->json($posts, 200);
    }

    public function show($id)
    {
    	$post = Post::find($id);

    	if (!$post) {
    		return response()->json(['error' => 'Post Not Found!'], 401);
    	}
    	
    	return response()->json($post, 200);
    }

    public function store(Request $request)
    {
    	$validatedData = Validator::make($request->all(), [
    		'title' => 'required',
    		'content' => 'required',
    	]);

    	if ($validatedData->fails()) {
    		return response()->json($validatedData->errors(), 401);
    	}

    	$post = Post::create($request->all());

    	return response()->json($post, 200);
    }

    public function update(Request $request, $id)
    {
    	$post = Post::find($id);

    	if (!$post) {
    		return response()->json(['error' => 'Post Not Found!'], 401);
    	}

    	$validatedData = Validator::make($request->all(), [
    		'title' => 'required',
    		'content' => 'required',
    	]);

    	if ($validatedData->fails()) {
    		return response()->json($validatedData->errors(), 401);
    	}

    	$post->title = $request->title;
    	$post->content = $request->content;
    	$post->update();

    }

    public function destroy($id)
    {
    	$post = Post::find($id);

    	if (!$post) {
    		return response()->json(['error' => 'Post Not Found!'], 401);
    	}

    	$post->delete();
    	return response()->json(['message' => 'Post Deleted!'], 200);
    }
}
