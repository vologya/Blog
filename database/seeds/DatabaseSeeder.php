<?php

use App\Tag;
use App\Post;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction( function() {
            $faker = \Faker\Factory::create();

            factory( User::class )
                ->create([
                    'name' => 'test',
                    'email' => 'test@test.test',
                    'password' => bcrypt('secret'),
                ]);

            $users = factory( User::class, 10 )->create();
            $tags = factory( Tag::class, 20 )->create();
            $posts = factory( Post::class, 50 )->make(['user_id' => 1]);

            foreach ($posts as $post) {
                $post->created_at = $post->updated_at = $faker->dateTimeBetween('-1year');
                $post->author()->associate( $users->random()->id );
                $post->save();
                $post->tags()->attach(
                    $faker->randomElements( $tags->pluck('id')->all(), rand(2,5) )
                );
            }

        });
    }
}
