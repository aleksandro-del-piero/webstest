<?php

namespace Tests\Feature\Api\V1;

use App\Models\Comment;
use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_view_comments(): void
    {
        $comment = Comment::factory()->published()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer your_api_token',
            'Accept' => 'application/json',
        ])->get("/api/v1/news/{$comment->news_id}/comments/{$comment->id}");

        $response->assertUnauthorized();
    }

    public function test_view_comments_for_auth_user(): void
    {
        $user = User::factory()->create();

        $token = $user->createToken('test user')->plainTextToken;

        $comment = Comment::factory()->published()->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}",
            'Accept' => 'application/json',
        ])->get("/api/v1/news/{$comment->news_id}/comments/{$comment->id}");

        $response->assertOk();
    }

    public function test_can_create_new_comment(): void
    {
        $user = User::factory()->create();

        $token = $user->createToken('test user')->plainTextToken;

        $news = News::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}",
            'Accept' => 'application/json',
        ])->post("/api/v1/news/{$news->id}/comments", [
            'comment' => 'New comment text'
        ]);

        $response->assertCreated();
    }

    public function test_can_create_new_comment_without_required_field(): void
    {
        $user = User::factory()->create();

        $token = $user->createToken('test user')->plainTextToken;

        $news = News::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}",
            'Accept' => 'application/json',
        ])->post("/api/v1/news/{$news->id}/comments");

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_authenticated_user_can_update_own_comment(): void
    {
        $user = User::factory()->create();

        $token = $user->createToken('test user')->plainTextToken;

        $comment = Comment::factory(['user_id' => $user->id])->published()->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}",
            'Accept' => 'application/json',
        ])->put("/api/v1/news/{$comment->news_id}/comments/{$comment->id}", [
            'comment' => 'Comment updated'
        ]);

        $response->assertNoContent();

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'comment' => 'Comment updated'
        ]);
    }

    public function test_user_cannot_update_someone_elses_comment(): void
    {
        $user = User::factory()->create();

        $token = $user->createToken('test user')->plainTextToken;

        $comment = Comment::factory()->published()->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}",
            'Accept' => 'application/json',
        ])->put("/api/v1/news/{$comment->news_id}/comments/{$comment->id}", [
            'comment' => 'Comment updated'
        ]);

        $response->assertForbidden();
    }

    public function test_authenticated_user_can_delete_own_comment(): void
    {
        $user = User::factory()->create();

        $token = $user->createToken('test user')->plainTextToken;

        $comment = Comment::factory(['user_id' => $user->id])->published()->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}",
            'Accept' => 'application/json',
        ])->delete("/api/v1/news/{$comment->news_id}/comments/{$comment->id}");

        $response->assertNoContent();

        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
            'comment' => 'Comment updated'
        ]);
    }

    public function test_user_cannot_delete_someone_elses_comment(): void
    {
        $user = User::factory()->create();

        $token = $user->createToken('test user')->plainTextToken;

        $comment = Comment::factory()->published()->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}",
            'Accept' => 'application/json',
        ])->delete("/api/v1/news/{$comment->news_id}/comments/{$comment->id}");

        $response->assertForbidden();
    }
}
