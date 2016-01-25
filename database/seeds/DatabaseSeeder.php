<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UserTableSeeder::class);
        $this->call(GroupTableSeeder::class);
        $this->call(AssessmentCategoryTableSeeder::class);
        $this->call(SubjectTableSeeder::class);
        $this->call(ExamTypeTableSeeder::class);

        Model::reguard();
    }
}
