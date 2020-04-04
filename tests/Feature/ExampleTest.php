<?php

namespace Tests\Feature;

use App\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testDatabase()
    {
        // Make call to application...

        $this->assertDatabaseHas('blog_posts', [
            'id' => '1',
        ]);
    }


    public function testNew_Post_Creation()
    {
        $post = new BlogPost();
        $post->title = "New title";
        $post->content = "New content";
        $post->save();
        $this->assertTrue($post->id !== null);
    }

}
