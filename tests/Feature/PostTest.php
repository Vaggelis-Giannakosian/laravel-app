<?php

namespace Tests\Feature;

use App\BlogPost;
use App\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Ramsey\Collection\Collection;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testNo_Blog_Posts_When_Nothing_In_Database()
    {
        $response = $this->get('/posts');
        $response->assertSeeText('No blog posts yet!');
        $response->assertStatus(200);
    }


    public function test_See_One_Blog_Post_When_There_Is_Only_One_With_No_Comments(){

        // Arrange
        $post = $this->createDummyPost();

        // Act
        $response = $this->get('/posts');
        // Assert

        $this->assertDatabaseHas('blog_posts', [
            'content' => 'Test post content',
        ]);
        $response->assertSeeText('Test Post');
        $response->assertSeeText('No comments yet!');
        $response->assertDontSeeText('Test post content');
        $response->assertStatus(200);
    }

    public function test_See_One_Blog_Post_When_There_Is_Only_One_With_Comments(){

        // Arrange
        $post = $this->createDummyPost();
        factory(Comment::class,4)->create(['blog_post_id'=>$post->id]);


        // Act
        $response = $this->get('/posts');
        // Assert

        $this->assertDatabaseHas('blog_posts', [
            'content' => 'Test post content',
        ]);
        $this->assertDatabaseHas('comments', [
            'blog_post_id'=> $post->id
        ]);
        $response->assertSeeText('Test Post');
        $response->assertSeeText('4 comments');
        $response->assertDontSeeText('Test post content');
        $response->assertStatus(200);
    }



    public function test_Store_Post_Valid()
    {
        $params = ['title'=>'New post','content'=>'content of this particular post'];
        $response = $this->post('/posts',$params);
        $response->assertStatus(302);
        $response->assertSessionHas('status');

        $this->assertEquals(session('status') , 'Blog post was created!');
        $this->assertDatabaseHas('blog_posts', [
            'content' => 'content of this particular post',
        ]);

    }

    public function test_Store_Post_Not_Valid()
    {
        $params = ['title'=>'New','content'=>'post'];
        $response = $this->post('/posts',$params);
        $response->assertStatus(302);
        $response->assertSessionMissing('status');

        $messages = session('errors')->getMessages();

        $this->assertEquals($messages['title'][0],'The title must be at least 5 characters.' );
        $this->assertEquals($messages['content'][0],'The content must be at least 10 characters.' );
        $response->assertSessionHasErrors(['title','content']);


        $this->assertDatabaseMissing('blog_posts', [
            'content' => 'post',
            'title'=>'New'
        ]);

    }
    public function test_Update_Post_Valid()
    {

        //Arrange section
        $post = $this->createDummyPost();
        $this->assertDatabaseHas('blog_posts', ['title'=>'Test Post','content'=>'Test post content']);

        $params = ['title'=>'New Post updated','content'=>'Post content updated'];

        //Act section
        $response = $this->patch("/posts/{$post->id}",$params);

        //Assert section
        $response->assertStatus(302);
        $response->assertSessionHas('status');
        $this->assertEquals(session('status'), 'Blog post was updated!');
        $response->assertSessionDoesntHaveErrors(['title','content']);


        $this->assertDatabaseHas('blog_posts', [
            'id' => $post->id,
            'content' => 'Post content updated',
            'title'=>'New Post updated'
        ]);
        $this->assertDatabaseMissing('blog_posts', [
            'id' => $post->id,
            'content' => 'Test post content',
            'title'=>'Test Post'
        ]);

    }

    public function test_Update_Post_Not_Valid()
    {

        //Arrange section
        $post = $this->createDummyPost();
        $this->assertDatabaseHas('blog_posts', ['id'=>$post->id,'title'=>'Test Post','content'=>'Test post content']);

        $params = ['title'=>'New','content'=>'Post'];

        //Act section
        $response = $this->patch("/posts/{$post->id}",$params);

        //Assert section
        $response->assertStatus(302);
        $response->assertSessionMissing('status');

        $response->assertSessionHasErrors(['title','content']);

        $messages = session('errors')->getMessages();
        $this->assertEquals($messages['title'][0],'The title must be at least 5 characters.' );
        $this->assertEquals($messages['content'][0],'The content must be at least 10 characters.' );


        $this->assertDatabaseMissing('blog_posts', [
            'id' => $post->id,
            'content' => 'Post content updated',
            'title'=>'New Post updated'
        ]);
        $this->assertDatabaseHas('blog_posts', [
            'id'=>$post->id,
            'title'=>'Test Post',
            'content' => 'Test post content'
        ]);
    }


    public function test_Post_Destroy_Working()
    {

        $post = $this->createDummyPost();
        $this->assertDatabaseHas('blog_posts',['id'=>$post->id,'title'=>'Test Post','content'=>'Test post content']);


        $response = $this->delete("/posts/{$post->id}");

        $response->assertStatus(302);
        $response->assertSessionHas('status');
        $this->assertEquals(session('status'),'Blog post was deleted!');
        $this->assertDatabaseMissing('blog_posts',['id'=>$post->id,'title'=>'Test Post','content'=>'Test post content']);
    }


    private function createDummyPost() : BlogPost
    {
        return factory(BlogPost::class)->states('test-post')->create();
    }


}
