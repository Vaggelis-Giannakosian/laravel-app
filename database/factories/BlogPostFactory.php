<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BlogPost;
use Faker\Generator as Faker;

$factory->define(BlogPost::class, function (Faker $faker) {
    return [
        'title'=>$faker->sentence(8),
        'content'=> $faker->paragraphs(5,true),
        'created_at' => $faker->dateTimeBetween('-3 months')
    ];
});

$factory->state(App\BlogPost::class, 'test-post',function(Faker $faker){
    return[
        'title' => 'Test Post',
        'content'=>'Test post content'
    ];
});

$factory->state(App\BlogPost::class, 'with-comments',function(Faker $faker){
    return[
        //leave empty if dont want to change any of the values
    ];
});

$factory->afterCreatingState(App\BlogPost::class,'with-comments',function(BlogPost $post, Faker $faker){
    $post->comments()->saveMany(factory(App\Comment::class,$faker->randomNumber(1))->make());
});
