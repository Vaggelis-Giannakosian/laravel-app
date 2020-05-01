<?php

namespace Tests;
use App\BlogPost;
use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function user(){
        return factory(User::class)->create();
    }

    protected function blogPost($userId=null)
    {
        return factory(BlogPost::class)->states('test-post')->create([
            'user_id' => $userId ?? $this->user()->id,
        ]);
    }
}
