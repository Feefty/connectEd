<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
        	[
        		'username'			=> 'admin',
        		'email'				=> 'admin@a.com',
        		'password'			=> bcrypt('qweqwe'),
                'group_id'          => 1
        	]
        ]);
    }
}
