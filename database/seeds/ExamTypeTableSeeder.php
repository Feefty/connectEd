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
                'name'      => 'Periodical Exam'
            ],
            [
                'name'      => 'Seatwork'
            ],
        	[
        		'name'		=> 'Quiz',
        	],
        	[
        		'name'		=> 'Home Work',
        	],
        ]);
    }
}
