<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class connectedTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $user = User::where('username', 'marvin')->first();
        $this->actingAs($user)
            ->visit('/grade_summary/data?student_id=13&school_year=2016')
            ->seeJson([
                'datasets' => [
                    [
                        'fillColor' => "rgba(220,220,220,0.5)",
                        'strokeColor' => "rgba(220,220,220,0.8)",
                        'highlightFill' => "rgba(220,220,220,0.75)",
                        'highlightStroke' => "rgba(220,220,220,1)",
                        'data' => [ 80, 83, 78, 79, 80 ]
                    ]
                ],
                'labels' => [
                    "Quarter 1",
                    "Quarter 2",
                    "Quarter 3",
                    "Quarter 4",
                    "Final"
                ]
            ]);
    }
}
