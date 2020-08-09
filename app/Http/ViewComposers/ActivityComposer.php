<?php
namespace App\Http\ViewComposers;

use App\Post;
use App\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class ActivityComposer {
    public function compose(View $view){
        $mostComments = Cache::remember('mostComments', now()->addSeconds(15), function(){
            return Post::mostCommented()->take(5)->get();
        });
        $mostUsersActive = Cache::remember('mostUsersActive', now()->addSeconds(15), function(){
            return User::usersActive()->take(5)->get();
        });
        $mostUsersActiveLastMonth = Cache::remember('mostUsersActiveLastMonth', now()->addSeconds(15), function(){
            return User::userActiveInLastMonth()->take(5)->get();
        }); 

        $view->with([
            'mostComments' => $mostComments,
            'mostUsersActive' => $mostUsersActive,
            'mostUsersActiveLastMonth' => $mostUsersActiveLastMonth
        ]);
    }
    
}