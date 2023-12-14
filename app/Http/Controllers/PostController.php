<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostController extends Controller
{
    // post controller
	public function index()
	{
		// Return all posts
		$posts = Post::all();
		
		return response()->json([
			'success' => true,
			'data' => $posts,
		], 200);
	}

	public function show($id)
	{
		// Return a single post
		$post = Post::find($id);
		
		if (!$post) {
			return response()->json([
				'success' => false,
				'message' => 'Post not found',
			], 400);
		}
		
		return response()->json([
			'success' => true,
			'data' => $post,
		], 200);
	}

	public function store(Request $request)
	{
		$postId = Str::uuid();
		
		try {
			// Validate request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
		
		// Store a new post
		$post = new Post();
		$post->id = $postId;
		$post->title = $request->title;
		$post->content = $request->content;
		$post->published_at = now();

// Associate the post with the authenticated user
        $user = Auth::user();
        $post->user()->associate($user);

		$post->save();
		
		return response()->json([
			'success' => true,
			'data' => $post,
			'message' => 'Post created successfully',
		], 200);
		} catch (\Exception $e) {
			//throw $th;
			return response()->json([
				'success' => false,
				'message' => $e->getMessage(),
			], 400);
		}
		
	}

	// Update a post
	public function update(Request $request, $id)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Update a post only if the authenticated user is the owner
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found',
            ], 400);
        }

        // Check if the authenticated user is the owner of the post
        if ($post->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to update this post',
            ], 403);
        }

        $post->title = $request->title;
        $post->content = $request->content;
        $post->updated_at = now();
        $post->save();

        return response()->json([
            'success' => true,
            'data' => $post,
        ], 200);
    }

	public function destroy($id)
    {
        // Delete a post only if the authenticated user is the owner
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found',
            ], 400);
        }

        // Check if the authenticated user is the owner of the post
        if ($post->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to delete this post',
            ], 403);
        }

        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully',
        ], 204);
    }
}
