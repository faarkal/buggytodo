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

    
    public function store(Request $request)
    {
       $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);
        Task::create($request->all());
        return redirect()->route('tasks.index');
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update($request->all()); 
        return redirect()->route('tasks.index');
    }

    
    public function destroy($id)
    {
        $task = Task::find($id);
        if ($task) {
            $task->delete();
        }
        return redirect()->route('tasks.index');
    }

    
    public function toggle(Request $request, $id)
    {
        $request->validate([
            'is_done' => 'boolean',
        ]);
        $task = Task::findOrFail($id);
        $task->is_done = !$task->is_done;
        $task->save();
        return redirect()->route('tasks.index');
    }

   
    public function search(Request $request)
    {
        $q = $request->query('q', '');
        $results = [];

        if ($q !== '') {
        $results = Task::where('title', 'LIKE', "%{$q}%")
            ->orderBy('created_at', 'desc')
            ->get();
        }

        return view('tasks.index', ['tasks' => $results, 'q' => $q, 'search' => true]);
    }
}
