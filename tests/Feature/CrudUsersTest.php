<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

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

    /** @test */
    function it_can_create_a_user()
    {
        $newUserRaw = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@doe.com'
        ];

        $response = $this->json('POST', '/api/users', $newUserRaw);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => 'john@doe.com'
        ]); 
    }

    /** @test */
    function it_can_get_a_user_by_id()
    {
        $user = factory(User::class)->create(['email' => 'john@doe.com']);

        $response = $this->json('GET', "/api/users/{$user->id}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'email' => $user->email
                ]
            ]);
    }

    /** @test */
    function it_can_update_a_user()
    {
        $userRaw = [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane@doe.com'
        ];
        $user = factory(User::class)->create($userRaw);
        $userRaw['first_name'] = 'Jimmy';
        $userRaw['email'] = 'jimmy@doe.com';

        $response = $this->json('PUT', "/api/users/{$user->id}", $userRaw);

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => $userRaw
            ]);
    }

    /** @test */
    function it_can_delete_a_user_by_id()
    {
        $user = factory(User::class)->create();
        $this->assertDatabaseHas('users', $user->toArray());

        $this->json('DELETE', "/api/users/{$user->id}");

        $this->assertDatabaseMissing('users', $user->toArray());
    }
}