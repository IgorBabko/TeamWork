<?php

namespace Tests\Feature;

use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CrudTasksTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_read_tasks()
    {
        $tasksRaw = [
            'name' => 'Test task',
            'description' => 'Some dummy description',
            'completed_flag' => true,
        ];
        factory(Task::class)->create($tasksRaw);

        $response = $this->get('/api/tasks');

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    $tasksRaw
                ]
            ]);
    }
}
