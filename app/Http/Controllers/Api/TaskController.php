<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Отобразить список всех задач.
     */
    public function index(Request $request)
{
    $search = $request->input('search');
    $sortBy = $request->input('sortBy', 'created_at');
    $sortOrder = $request->input('sortOrder', 'desc');
    $categoryId = $request->input('category_id');

    $tasks = Task::query()
        ->when($search, function ($query, $search) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        })
        ->when($categoryId, function ($query, $categoryId) {
            $query->where('category_id', $categoryId);
        })
        ->orderBy($sortBy, $sortOrder)
        ->paginate(5);

    return response()->json($tasks);
}

    /**
     * Сохранить новую задачу.
     */
    public function store(Request $request)
    {
        // Валидация данных
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'boolean',
        ]);

        // Создание новой задачи
        $task = Task::create($validated);

        return response()->json($task, 201); // HTTP 201: Created
    }

    /**
     * Показать одну задачу.
     */
    public function show(Task $task)
    {
        return response()->json($task);
    }

    /**
     * Обновить задачу.
     */
    public function update(Request $request, Task $task)
    {
        // Валидация данных
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'boolean',
        ]);

        // Обновление задачи
        $task->update($validated);

        return response()->json($task);
    }

    /**
     * Удалить задачу.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully.']);
    }
}
