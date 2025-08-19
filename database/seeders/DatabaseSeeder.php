<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Task::create(['title' => 'Read Laravel docs', 'is_done' => false]);
        Task::create(['title' => 'Write tests (later)', 'is_done' => false]);

        // Intentionally stored XSS payload
        Task::create(['title' => "<img src=x onerror=alert('xss')>", 'is_done' => false]);
    }
}
