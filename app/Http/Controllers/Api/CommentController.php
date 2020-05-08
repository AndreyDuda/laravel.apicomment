<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController
{
    /**
     * Display a listing of the resource.
     *
     *@return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function list(Request $request)
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
                ->whereNull('parent_id')->paginate($request->get('limit', 25));
        return CommentResource::collection($comment);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request)
    {
        $comment = Comment::create($request->all());

        return response($comment->toArray(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show($id)
    {
        $code = 200;
        try {
            $result = Comment::find($id)->limit(1)->get();
        }  catch (\Exception $ex) {
            $code = 422;
            $result = ['error' => 'invalid argument'];
        }

        return CommentResource::collection($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $code = 422;
        $comment = Comment::where('id', $id)->first();
        if ($comment) {
            $result = $comment->update($request->all());
        }

        return response()->json($result, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $comment = Comment::where('id', $id)->delete();
        return response()->json(['Success' => 'ок'], 204);
    }
}
