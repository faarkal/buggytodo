<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::orderBy('created_at', 'desc')->get();
        return view('tasks.index', compact('tasks'));
    }

    // Intentionally missing validation; uses mass assignment with all input
    public function store(Request $request)
    {
        // Students should add validation and select only allowed fields
        Task::create($request->all());
        return redirect()->route('tasks.index');
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update($request->all()); // same mass assignment issue
        return redirect()->route('tasks.index');
    }

    // Intentionally uses GET route to delete (see routes)
    public function destroy($id)
    {
        $task = Task::find($id);
        if ($task) {
            $task->delete();
        }
        return redirect()->route('tasks.index');
    }

    // Race-prone toggle (no transactions/locking)
    public function toggle(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->is_done = !$task->is_done;
        $task->save();
        return redirect()->route('tasks.index');
    }

    // Intentionally vulnerable SQL search using whereRaw string interpolation
    public function search(Request $request)
    {
        $q = $request->query('q', '');
        $results = [];

        if ($q !== '') {
            // Vulnerable to SQL injection if special characters are used.
            $results = Task::whereRaw("title LIKE '%{$q}%'")
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('tasks.index', ['tasks' => $results, 'q' => $q, 'search' => true]);
    }
}
