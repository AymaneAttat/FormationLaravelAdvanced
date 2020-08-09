<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = App\Post::all();
        if($posts->count() == 0){
            $this->command->info("Please create some posts !");
            return ;
        }
        $users = App\User::all();
        if($users->count() == 0){
            $this->command->info("Please create some users !");
            return ;
        }
        $nbComments = (int)$this->command->ask("How many of comment you want to generate ?", 15);
        factory(App\Comment::class, $nbComments)->make()->each(function($comment) use ($posts, $users){
            $comment->commentable_id = $posts->random()->id;
            $comment->commentable_type = 'App\Post';
            $comment->user_id = $users->random()->id;
            $comment->save();
        });
    }
}
