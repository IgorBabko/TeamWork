<?php

namespace Tests\Feature;

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
        $response = $this->get('/api/users');

        dd($response);

        $response->assertStatus(200);
    }
}
