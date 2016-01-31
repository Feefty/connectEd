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
            ->visit('/lesson/view/2')
            ->see('Columban College, Inc.')
            ->see('Marvin Guela')
            ->see('AP');
    }
}
