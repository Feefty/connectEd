<?php

use Illuminate\Database\Seeder;
use App\AssessmentCategory;

class AssessmentCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AssessmentCategory::insert([
            [
                'name'      => 'Written Works'
            ],
            [
                'name'      => 'Performance Tasks'
            ],
            [
                'name'      => 'Quarterly Assessment'
            ]
        ]);
    }
}
