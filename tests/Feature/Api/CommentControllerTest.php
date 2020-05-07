<?php
declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\Comment;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    public function testList()
    {
        $comments = Factory(Comment::class, 50)->create();;

        $this->json('GET', 'api/comment', [])
            ->assertStatus(200);
    }

    public function testStore()
    {
        $headers = [
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json'
        ];

        $comment = [
            'post_id' => 1,
            'author_name' => 'name secondName',
            'text' => 'testing saving comment'
        ];

        $this->json('POST', '/api/comment', $comment, $headers)
            ->assertStatus(200)
            ->assertJson($comment);
        $this->assertDatabaseHas('comments', $comment);

    }

    public function testShow()
    {
        $comment = factory(Comment::class,1)->create();
        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->json('GET', '/api/comment/' . $comment['0']['id'], [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                "data" => [ 0 =>  ["id","post_id","parent_id","author_name","text","created_at","updated_at",]]
            ]);

        //$response = $response->decodeResponseJson();

       // $this->assertEquals($comment->toArray()[0], $response['data'][0]);
    }

    public function testUpdate()
    {
        $headers = [
            'Accept' => 'application/json'
        ];
        $comment = factory(Comment::class, 1)->create();
        $commentUpdate = ['text' => 'text update'];

        $this->json('put', '/api/comment/' . $comment['0']['id'], $commentUpdate, $headers)
            ->assertStatus(200);

    }

    public function destroy()
    {
        $headers = [
            'Accept' => 'application/json'
        ];

        $comment = factory(Comment::class, 1)->create();

        $this->json('DELETE', '/api/comment/' . $comment['0']['id'], [], $headers)
            ->assertStatus(204)
            ->assertJson(['Success' => 'ок']);

        $this->assertSoftDeleted($comment);
    }
}
