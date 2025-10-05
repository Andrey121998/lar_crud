<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::get();
        return response()->json($tasks, 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Store a newly created resource in storage.
     */
 public function store(TaskRequest $request)
    {
        $validated = $request->validated();

        $task = new Task();
        $task->title = $validated['title'];
        $task->description = $validated['description'] ?? null;
        $task->status = $validated['status'];
        $task->save();

        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::find($id);
        return response()->json($task, 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(TaskRequest $request, string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $validated = $request->validated();

        $task->title = $validated['title'];
        $task->description = $validated['description'] ?? null;
        $task->status = $validated['status'];
        $task->save();

        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Task::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
