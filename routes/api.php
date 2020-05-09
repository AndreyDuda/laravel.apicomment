<?php

Route::prefix('comment')->group(
    function () {
        Route::get('/', 'Api\CommentController@list');
        Route::get('post/{post_id}', 'Api\CommentController@list');
        Route::get('/{comment_id}', 'Api\CommentController@show');
        Route::post('/', 'Api\CommentController@store');
        Route::put('/{comment_id}', 'Api\CommentController@update');
        Route::delete('/{comment_id}', 'Api\CommentController@destroy');
    }
);
