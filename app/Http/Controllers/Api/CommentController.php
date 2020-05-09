<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Comment\ListCommentRequest;
use App\Http\Requests\Api\Comment\StoreCommentRequest;
use App\Http\Requests\Api\Comment\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;

class CommentController
{
    /**
     * Display a listing of the resource.
     *
     *@return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function list(ListCommentRequest $request)
    {
        $comment =
            Comment::when(
                $request->has('post_id'),
                static function ($query) use ($request) {
                    $query
                        ->where('post_id', $request->get('post_id'));
                }
            )
                ->with('replies')
                ->whereNull('parent_id')
                ->orderBy('created_at', 'DESC')
                ->paginate($request->get('limit', 25));
        return CommentResource::collection($comment);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCommentRequest $request)
    {
        $comment = Comment::create($request->all());
        return (new CommentResource($comment))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $comment = Comment::findOrFail($id);
        return (new CommentResource($comment))->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCommentRequest $request, $id)
    {
        $comment = Comment::find($id);
        $comment->update($request->all());
        return (new CommentResource($comment))->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Comment::where('id', $id)->delete();
        return response()->json(['Success' => 'ок'], 204);
    }
}
