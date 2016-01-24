<?php

use Illuminate\Database\Seeder;
use App\Group;

class GroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Group::insert([
        	[
        		'name'		=> 'System Admin',
        		'level'		=> 99,
        		'description'=> 'Facilitator of the system',
        		'created_at'=> new \DateTime
        	],
        	[
        		'name'		=> 'School Admin',
        		'level'		=> 25,
        		'description'=> 'Facilitator of the school',
        		'created_at'=> new \DateTime
        	],
        	[
        		'name'		=> 'Teacher',
        		'level'		=> 5,
        		'description'=> 'School teacher',
        		'created_at'=> new \DateTime
        	],
        	[
        		'name'		=> 'Student',
        		'level'		=> 3,
        		'description' => 'Student',
        		'created_at'=> new \DateTime
        	],
        	[
        		'name'		=> 'Parent',
        		'level'		=> 2,
        		'description' => 'Student\'s Parent',
        		'created_at'=> new \DateTime
        	],
        	[
        		'name'		=> 'Guest',
        		'level'		=> 1,
        		'description' => '',
        		'created_at'=> new \DateTime
        	],
        	[
        		'name'		=> 'Banned',
        		'level'		=> 0,
        		'description' => '',
        		'created_at'=> new \DateTime
        	]
        ]);
    }
}
