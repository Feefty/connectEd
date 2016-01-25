<?php

use Illuminate\Database\Seeder;
use App\Subject;

class SubjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subject::insert([
            [
                'name'          => 'Mother Tongue',
                'code'          => 'MT',
                'description'   => '',
                'created_at'    => new \DateTime
            ],
            [
                'name'          => 'Filipino',
                'code'          => 'FIL',
                'description'   => '',
                'created_at'    => new \DateTime
            ],
            [
                'name'          => 'English',
                'code'          => 'ENG',
                'description'   => '',
                'created_at'    => new \DateTime
            ],
            [
                'name'          => 'Mathematics',
                'code'          => 'MTH',
                'description'   => '',
                'created_at'    => new \DateTime
            ],
            [
                'name'          => 'Science',
                'code'          => 'SCN',
                'description'   => '',
                'created_at'    => new \DateTime
            ],
            [
                'name'          => 'Araliong Panlipunan',
                'code'          => 'AP',
                'description'   => '',
                'created_at'    => new \DateTime
            ],
            [
                'name'          => 'Edukasyon sa Pagpapakatao (EsP)',
                'code'          => 'EsP',
                'description'   => '',
                'created_at'    => new \DateTime
            ],
            [
                'name'          => 'Music',
                'code'          => 'MUS',
                'description'   => '',
                'created_at'    => new \DateTime
            ],
            [
                'name'          => 'Arts',
                'code'          => 'ART',
                'description'   => '',
                'created_at'    => new \DateTime
            ],
            [
                'name'          => 'Physical Education',
                'code'          => 'PE',
                'description'   => '',
                'created_at'    => new \DateTime
            ],
            [
                'name'          => 'Health',
                'code'          => 'HLT',
                'description'   => '',
                'created_at'    => new \DateTime
            ],
            [
                'name'          => 'Edukasyon Pantahanan at Pangkabuhayan (EPP)',
                'code'          => 'EPP',
                'description'   => '',
                'created_at'    => new \DateTime
            ],
            [
                'name'          => 'Technology and Livelihood Education (TLE)',
                'code'          => 'TLE',
                'description'   => '',
                'created_at'    => new \DateTime
            ]
        ]);
    }
}
