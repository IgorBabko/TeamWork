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
        $taskRaw = [
            'name' => 'Test task',
            'description' => 'Some dummy description',
            'completed_flag' => true,
        ];
        factory(Task::class)->create($taskRaw);

        $response = $this->get('/api/tasks');

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    $taskRaw
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

    /** @test */
    function it_can_update_a_task()
    {
        $taskRaw = [
            'name' => 'Test task',
            'description' => 'Some dummy description',
            'completed_flag' => true,
        ];
        $task = factory(Task::class)->create($taskRaw);
        $taskRaw['name'] = 'Another task';
        $taskRaw['description'] = 'Another dummy description';

        $response = $this->json('PUT', "/api/tasks/{$task->id}", $taskRaw);

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => $taskRaw
            ]);
    }

    /** @test */
    function it_can_delete_a_task_by_id()
    {
        $task = factory(Task::class)->create();
        $this->assertDatabaseHas('tasks', $task->toArray());

        $this->json('DELETE', "/api/tasks/{$task->id}");

        $this->assertDatabaseMissing('tasks', $task->toArray());
    }
}
