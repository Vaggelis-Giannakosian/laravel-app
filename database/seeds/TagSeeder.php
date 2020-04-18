<?php

use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = App\BlogPost::all();
        if($posts->count() === 0)
        {
            $this->command->info('There are no blog posts, so no tags will be added');
            return;
        }


        $tagsCount = (int) $this->command->ask('How many tags would you like?',30);
        factory(App\Tag::class,$tagsCount)->make()->each(function($tag) use ($posts){
            $tag->save();
            $tag->posts()->syncWithoutDetaching($posts->random(4));
        });
    }
}
