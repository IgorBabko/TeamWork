<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CrudUsersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_read_users()
    {
        $userRaw = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@doe.com'
        ];
        factory(User::class)->create($userRaw);

        $response = $this->get('/api/users');

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    $userRaw
                ]
            ]);
    }
}
