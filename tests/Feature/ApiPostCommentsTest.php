<?php

namespace Tests\Feature;

use App\BlogPost;
use App\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiPostCommentsTest extends TestCase
{

    use RefreshDatabase;


    public function testNewBlogPostDoesNotHaveComments()
    {
       $post = $this->blogPost();

       $response = $this->json('GET',"/api/v1/posts/{$post->id}/comments");


       $this->assertDatabaseHas('blog_posts',['id'=>$post->id,'title'=>'Test Post','content'=>'Test post content']);
       $response->assertStatus(200)
           ->assertJsonStructure(['data','links','meta'])
           ->assertJsonCount(0,'data');

    }

    public function testBlogPostHas10Comments()
    {
        $post = $this->blogPost();
        $post->comments()->saveMany(factory(Comment::class,10)->make([
            'user_id' => $this->user()->id
        ]));

        $response = $this->json('GET',"/api/v1/posts/{$post->id}/comments?per_page=10");

        $this->assertDatabaseHas('blog_posts',['id'=>$post->id,'title'=>'Test Post','content'=>'Test post content']);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*'=>[
                        'comment_id',
                        'content',
                        'created_at',
                        'updated_at',
                        'user'=>[
                            'id',
                            'name'
                        ]
                    ]
                ],
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next'
                ],
                'meta'=>[
                    'current_page',
                    'from',
                    'last_page',
                    'path',
                    'per_page',
                    'to',
                    'total'
                ]])
            ->assertJsonCount(10,'data');

    }



    public function testAddingCommentsWhenNotAuthenticated()
    {
        $post = $this->blogPost();

        $response = $this->json('POST',"/api/v1/posts/{$post->id}/comments",['content'=>'api-comment-added']);

        $response->assertUnauthorized();

    }

    public function testAddingCommentsWhenAuthenticated()
    {
        $post = $this->blogPost();

        $response = $this->actingAs($this->user(),'api')->json('POST',"/api/v1/posts/{$post->id}/comments",['content'=>'api-comment-added']);

        $this->assertDatabaseHas('comments',[
            'commentable_id'=>$post->id,
            'commentable_type' => BlogPost::class,
            'content'=>'api-comment-added'
        ]);
        $response->assertStatus(201);
    }

    public function testAddingCommentsWhenAuthenticatedInvalidData()
    {
        $post = $this->blogPost();

        $response = $this->actingAs($this->user(),'api')->json('POST',"/api/v1/posts/{$post->id}/comments",['content'=>'api']);


        $this->assertDatabaseMissing('comments',[
            'commentable_id'=>$post->id,
            'commentable_type' => BlogPost::class,
            'content'=>'api'
        ]);
        $response->assertStatus(422)->assertJson([
            "message" => "The given data was invalid.",
            "errors" => [
                "content" => [
                    "The content must be at least 5 characters."
                ]
            ]
        ]);
    }

}
