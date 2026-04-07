<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($projectId)
    {
        $tasks = Task::where('project_id', $projectId)->get();
        return response()->json(['data' => $tasks], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Não usado em API
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $projectId)
    {
        $rules = [
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
        ];

        $request->validate($rules);

        $task = Task::create($request->all());

        return response()->json(['data' => $task], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($projectId, $taskId)
    {
        $task = Task::where('project_id', $projectId)->where('id', $taskId)->first();

        if (!$task) {
            return response()->json(['message' => 'Task not found in this project'], 404);
        }

        return response()->json(['data' => $task], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Não usado em API
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $projectId, $taskId)
    {
        $rules = [
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
        ];

        $request->validate($rules);

        $task = Task::where('project_id', $projectId)->where('id', $taskId)->first();
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->update($request->all());

        return response()->json(['data' => $task], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($projectId, $taskId)
    {
        $task = Task::where('project_id', $projectId)->where('id', $taskId)->first();
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->delete();
        return response()->json(['message' => 'Task deleted successfully'], 200);
    }


    /**
     * Attach a tag to a task.
     * POST /api/tasks/{taskId}/tags/{tagId}
     */
    public function attachTag($taskId, $tagId)
    {
        // 1. Acha a tarefa pelo ID direto (não importa o projeto)
        $task = Task::find($taskId);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        // 2. Adiciona a ligação na tabela pivô
        $task->tags()->attach($tagId);

        return response()->json(['message' => 'Tag attached to task successfully'], 200);
    }

/**
     * Remove apenas a associação entre uma Tarefa e uma Tag.
     * DELETE /api/tasks/{taskId}/tags/{tagId}
     */
    public function detachTag($taskId, $tagId)
    {
        // 1. Acha a tarefa pelo ID direto (não importa o projeto)
        $task = Task::find($taskId);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        // 2. Remove apenas a ligação na tabela pivô
        $task->tags()->detach($tagId);

        return response()->json(['message' => 'Tag removed from task successfully'], 200);
    }
}
