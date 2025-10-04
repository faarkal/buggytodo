@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-6">
    <div class="card shadow-sm mb-4">
      <div class="card-header">Add Task (Buggy)</div>
      <div class="card-body">
        <form action="{{ route('tasks.store') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" placeholder="e.g., Fix bugs">
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="1" name="is_done" id="is_done">
            <label class="form-check-label" for="is_done">Mark as done</label>
          </div>
          <button class="btn btn-primary">Save</button>
        </form>
       
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card shadow-sm mb-4">
      <div class="card-header">Tasks</div>
      <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0">
          <thead>
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Status</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($tasks as $task)
              <tr>
                <td>{{ $task->id }}</td>
                <td>{!! $task->title !!}</td>
                <td>
                  @if($task->is_done)
                    <span class="badge bg-success">Done</span>
                  @else
                    <span class="badge bg-secondary">Open</span>
                  @endif
                </td>
                <td class="text-end">
                  <form class="d-inline" action="{{ route('tasks.toggle', $task->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-sm btn-outline-secondary">Toggle</button>
                  </form>

                  
                  <a href="{{ route('tasks.destroy.get', $task->id) }}" class="btn btn-sm btn-outline-danger">Delete</a>
                </td>
              </tr>
            @empty
              <tr><td colspan="4" class="text-center p-4 text-muted">No tasks</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
