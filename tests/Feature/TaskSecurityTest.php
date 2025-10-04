<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Task;

class TaskSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_escapes_title_to_prevent_xss(): void
    {
        $payload = '<script>alert("xss")</script>';
        Task::factory()->create(['title' => $payload]);

        $res = $this->get(route('tasks.index'));
        $res->assertStatus(200);
        $res->assertDontSee('<script', false);
        $res->assertSee(e($payload), false);
    }

    public function test_search_handles_malicious_input_without_crashing(): void
    {
        Task::factory()->create(['title' => 'hello']);
        $attack = "' OR '1'='1";
        $res = $this->get(route('tasks.search', ['q' => $attack]));
        $res->assertStatus(200);
        $res->assertSee('No tasks');
    }

    public function test_deleting_over_get_is_rejected(): void
    {
        $task = Task::factory()->create();
        $res = $this->get('/tasks/delete/' . $task->id);
        $res->assertStatus(405);
        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }
}
