<?php
declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\Comment;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    public function testList()
    {
        Factory(Comment::class, 1)->create();;

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
            ->assertStatus(201);
        $this->assertDatabaseHas('comments', $comment);
    }

    public function testShow()
    {
        $comment = factory(Comment::class,1)->create()->first();
        $headers = [
            'Accept' => 'application/json'
        ];

        $this->json('GET', '/api/comment/' . $comment->id, [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    "id","post_id","parent_id","author_name","text","created_at","updated_at"
                ]
            ]);
    }

    public function destroy()
    {
        $headers = [
            'Accept' => 'application/json'
        ];

        $comment = factory(Comment::class, 1)->create()->first();

        $this->json('DELETE', '/api/comment/' . $comment->id, [], $headers)
            ->assertStatus(204)
            ->assertJson(['Success' => 'ок']);

        $this->assertSoftDeleted($comment);
    }

    public function testUpdate()
    {
        $headers = [
            'Accept' => 'application/json'
        ];
        $comment = factory(Comment::class, 1)->create()->first();
        $commentUpdate = [
            'author_name' => 'New Name',
            'post_id' => 1,
            'text' => 'text update',
        ];

        $this->json('put', '/api/comment/' . $comment->id, $commentUpdate, $headers)
            ->assertStatus(200);
    }
}
