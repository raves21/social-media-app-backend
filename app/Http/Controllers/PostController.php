<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PostResource::collection(Post::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request)
    {
        $currentUserId = $request->user()->id;

        $newPost = Post::create([...$request->validated(), 'user_id' => $currentUserId]);
        return new PostResource($newPost);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $foundPost = Post::findOrFail($id);

        return new PostResource($foundPost);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, string $id)
    {
        $foundPost = Post::findOrFail($id);
        $updatedPost = $foundPost->update($request->validated());

        return new PostResource($updatedPost);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Post::destroy($id);

        return ["message" => "deleted successfully."];
    }

    /**
     * Retrieves a certain user's posts
     * 
     * @param string $id The id of the user
     */
    public function getUserPosts(string $id)
    {
        $foundPosts = Post::where('user_id', '=', $id)->paginate(10);

        return PostResource::collection($foundPosts);
    }

    public function getCurrentUserPosts(Request $req)
    {
        $currentUser = $req->user();
        $currentUserPosts = Post::where('user_id', '=', $currentUser->id)->paginate(10);

        return PostResource::collection($currentUserPosts);
    }
}
