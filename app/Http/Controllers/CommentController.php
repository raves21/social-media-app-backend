<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CommentResource::collection(Comment::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentStoreRequest $request, string $postId)
    {
        $request->merge(['post_id', $postId]);
        $currentUserId = $request->user()->id;

        $newComent = Comment::create([...$request->validated(), 'user_id' => $currentUserId]);

        return new CommentResource($newComent);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $foundComment = Comment::findOrFail($id);

        return new CommentResource($foundComment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentUpdateRequest $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Comment::destroy($id);

        return ["message" => "successfully deleted."];
    }
}
