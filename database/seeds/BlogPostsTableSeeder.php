<?php

use Illuminate\Database\Seeder;

class BlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $postsCount = (int) $this->command->ask('How many posts would you like?',50);
        $users = App\User::all();
        factory(App\BlogPost::class,$postsCount)->make()->each(function ($post) use ($users){
//            FIRST WAY
//            $users->random()->posts()->save($post);
//            SECOND WAY
//            $post->user()->associate($users->random())->save();
//            THIRD WAY
//            $post->user()->associate($users->random()->id)->save();
//            FOURTH WAY
            $post->user_id = $users->random()->id;
            $post->save();
        });
    }
}
