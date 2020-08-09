<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if($this->command->confirm("Do you want to refresh the database ?", true)){
            $this->command->call("migrate:refresh"); //you don't need to write php artisan
            $this->command->info("database was refreshed !");
        }
        $this->call([UsersTableSeeder::class, PostsTableSeeder::class, CommentsTableSeeder::class, TagTableSeeder::class, PostTagTableSeeder::class]);
        /* Method 1 
        $users = factory(App\User::class, 5)->create();
        $posts = factory(App\Post::class, 7)->make()->each(function($post) use ($users){
            $post->user_id = $users->random()->id;
            $post->save();
        });
        $comments = factory(App\Comment::class, 15)->make()->each(function($comment) use ($posts){
            $comment->post_id = $posts->random()->id;
            $comment->save();
        });
        */
    }
}
