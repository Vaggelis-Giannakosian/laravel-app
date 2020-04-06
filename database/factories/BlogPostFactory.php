<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BlogPost;
use Faker\Generator as Faker;

$factory->define(BlogPost::class, function (Faker $faker) {
    return [
        'title'=>$faker->sentence(8),
        'content'=> $faker->paragraphs(5,true)
    ];
});

$factory->state(App\BlogPost::class, 'test-post',function(Faker $faker){
    return[
        'title' => 'Test Post',
        'content'=>'Test post content'
    ];
});
