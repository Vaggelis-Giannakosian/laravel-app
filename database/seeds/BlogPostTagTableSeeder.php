<?php

use App\BlogPost;
use App\Tag;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class BlogPostTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $tags = Tag::all();
//        $tags = Tag::inRandomOrder()->get();
        $posts = BlogPost::all();

        if($tags->count() === 0){
            $this->command->info('No tags found, skipping assigning tags to blog posts');
            return;
        }

        $howManyMin = (int) $this->command->ask('Minimum tags on blog posts?', 0);
        $howManyMax = min( (int) $this->command->ask('Maximum tags on blog posts?', $tags->count()), $tags->count());

        $posts->each(function(BlogPost $post) use ($tags, $howManyMin, $howManyMax){
            $take = random_int($howManyMin,$howManyMax);
            $post->tags()->sync($tags->pluck('id')->random($take));
        });


    }
}
