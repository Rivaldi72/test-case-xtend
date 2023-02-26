<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResources;

class PostController extends Controller
{
    public function index()
    {
        $this->authorize('show-all-posts');
        $users = Post::all();

        return PostResources::collection($users);
    }

    public function store(Request $request)
    {
        $post = new Post([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
        ]);

        $post->save();

        return response()->json([
            'success' => true,
            'message' => 'Add Post Success',
            'data' => $post,
        ]);
    }

    public function show(Post $post)
    {
        return new PostResources($post);
    }

    public function update(Request $request, Post $post)
    {
        $post->update($request->all());

        return new PostResources($post);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Delete Post Success',
        ]);
    }
}
