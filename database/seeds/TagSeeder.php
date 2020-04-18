<?php

use App\Tag;
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
        collect(['Science', 'Sport', 'Politics', 'Entertainment', 'Economy'])
            ->each(
                function ($tag) {
                    $tag = Tag::create(['name' => $tag]);
                });
    }
}
