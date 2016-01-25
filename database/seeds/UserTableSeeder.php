<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Profile;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create(
        	[
        		'username'			=> 'admin',
        		'email'				=> 'admin@a.com',
        		'password'			=> bcrypt('qweqwe'),
                'group_id'          => 1
        	]
        );

        Profile::create([
            'user_id' => $user->id
        ]);
    }
}
