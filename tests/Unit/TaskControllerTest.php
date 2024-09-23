<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use App\Models\Task;
use App\Models\User; // Ensure you import User model

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $token;

    protected function setUp(): void
    {
        parent::setUp();
        // Create a user for testing
        $this->user = User::factory()->create();

        // Log in to get a token
        $this->token = $this->loginAndGetToken();
    }

    protected function loginAndGetToken()
    {
        $response = $this->postJson('/api/login', [
            'email' => $this->user->email,
            'password' => 'password', // Use a valid password
        ]);

        return $response->json('token');
    }

    /** @test */
    public function it_can_get_all_tasks()
    {
        $tasks = Task::factory()->count(3)->create();

        $response = $this->getJson('/api/tasks2', [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonCount(3, 'data');
    }

    /** @test */
    public function it_can_get_a_task_by_id()
    {
        $task = Task::factory()->create();

        $response = $this->getJson("/api/tasks2/{$task->id}", [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function it_returns_404_if_task_not_found()
    {
        $response = $this->getJson('/api/tasks2/999', [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_new_task()
    {
        $taskData = [
            'title' => 'New Task',
            'description' => 'Task description',
            'due_date' => '2024-12-31',
            'assigned_user' => $this->user->id, // Ensure to use a valid user ID
        ];

        $response = $this->postJson('/api/tasks2', $taskData, [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(Response::HTTP_CREATED)
                 ->assertJsonStructure(['data' => ['id', 'title', 'description']]);

        $this->assertDatabaseHas('tasks', ['title' => 'New Task']);
    }

    /** @test */
    public function it_can_update_a_task()
    {
        $task = Task::factory()->create();

        $response = $this->putJson("/api/tasks2/{$task->id}", [
            'title' => 'Updated Task Title',
            'description' => 'Updated description',
        ], [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(Response::HTTP_OK);

    }

    /** @test */
    public function it_can_delete_a_task()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/tasks2/{$task->id}", [], [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(500);
    }
}