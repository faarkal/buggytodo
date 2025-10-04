<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Task;

class TaskModelTest extends TestCase
{
    public function test_is_done_should_not_be_mass_assignable(): void
    {
        $task = new Task(['title' => 'X', 'is_done' => 1]);
        $this->assertNotEquals(1, $task->is_done ?? null, 'is_done tidak boleh mass-assignable.');
    }
}
