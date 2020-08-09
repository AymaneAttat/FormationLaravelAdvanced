<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(array(
            'email' => 'aynan_45@live.fr',
            'password' => Hash::make('hicham1998'),
            'email_verified_at' => now(),
            'name' => 'Aymane',
            'is_admin'=>1,
            'locale' => 'en'
        ));
        $nbUsers = (int)$this->command->ask("How many of user you want generate ?", 5);
        factory(App\User::class, $nbUsers)->create();
    }
}
