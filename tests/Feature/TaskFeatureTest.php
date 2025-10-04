<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Task;

class TaskFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_shows_task_list_page(): void
    {
        Task::factory()->count(2)->create();
        $res = $this->get(route('tasks.index'));
        $res->assertStatus(200);
        $res->assertSee('Add Task');
    }

    public function test_can_create_task_with_valid_data(): void
    {
        $payload = ['title' => 'Write tests'];
        $res = $this->post(route('tasks.store'), $payload);
        $res->assertStatus(302);
        $this->assertDatabaseHas('tasks', ['title' => 'Write tests']);
    }

    public function test_store_requires_title(): void
    {
        $res = $this->post(route('tasks.store'), []);
        $res->assertSessionHasErrors('title');
        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_toggle_flips_is_done(): void
    {
        $task = Task::factory()->create(['is_done' => false]);
        $res = $this->post(route('tasks.toggle', $task->id));
        $res->assertStatus(302);
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'is_done' => 1]);
    }

    public function test_update_requires_title(): void
    {
        $task = Task::factory()->create();
        $res = $this->post(route('tasks.update', $task->id), []);
        $res->assertSessionHasErrors('title');
    }

    public function test_can_update_title(): void
    {
        $task = Task::factory()->create(['title' => 'Old']);
        $res = $this->post(route('tasks.update', $task->id), ['title' => 'New']);
        $res->assertStatus(302);
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'New']);
    }
}
