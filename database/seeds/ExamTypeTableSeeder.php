<?php

use Illuminate\Database\Seeder;
use App\ExamType;

class ExamTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExamType::insert([
        	[
        		'name'		=> '1st Prelim',
        	],
        	[
        		'name'		=> '1st Preodical',
        	],
        	[
        		'name'		=> '2nd Prelim',
        	],
        	[
        		'name'		=> '2nd Preodical',
        	],
        	[
        		'name'		=> '3rd Prelim',
        	],
        	[
        		'name'		=> '3rd Preodical',
        	],
        	[
        		'name'		=> '4th Prelim',
        	],
        	[
        		'name'		=> '4th Preodical',
        	],
        	[
        		'name'		=> 'Quiz',
        	],
        	[
        		'name'		=> 'Assignment',
        	],
        ]);
    }
}
