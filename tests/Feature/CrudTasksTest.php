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

    /** @test */
    function it_can_create_a_task()
    {
        $newTaskRaw = [
            'name' => 'Test task',
            'description' => 'Some dummy description',
            'completed_flag' => true,
        ];

        $response = $this->json('POST', '/api/tasks', $newTaskRaw);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', [
            'name' => 'Test task'
        ]); 
    }

    /** @test */
    function it_can_get_a_task_by_id()
    {
        $task = factory(Task::class)->create(['name' => 'Test task']);

        $response = $this->json('GET', "/api/tasks/{$task->id}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => $task->name
                ]
            ]);
    }
}
