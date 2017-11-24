<?php

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

            factory( User::class )
                ->create([
                    'name' => 'test',
                    'email' => 'test@test.test',
                    'password' => bcrypt('secret'),
                ]);

            $users = factory( User::class, 10 )->create();

            $posts = factory( Post::class, 50 )->make(['user_id' => 1]);
            foreach ($posts as $post) {
                $post->author()->associate( $users->random()->id );
                $post->save();
            }

        });
    }
}
