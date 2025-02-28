<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category; // Подключаем модель категорий
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Отобразить список задач.
     */
    public function index(Request $request)
{
    $search = $request->input('search');
    $sortBy = $request->input('sortBy', 'created_at'); // Сортировка по умолчанию
    $sortOrder = $request->input('sortOrder', 'desc'); // Порядок сортировки по умолчанию
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
        ->paginate(5)
        ->withQueryString();

    $categories = \App\Models\Category::all(); // Получаем все категории

    return view('tasks.index', compact('tasks', 'categories', 'search', 'sortBy', 'sortOrder'));
}


    /**
     * Показать форму создания новой задачи.
     */
    public function create()
    {
        $categories = Category::all();
        return view('tasks.create', compact('categories'));
    }

    /**
     * Сохранить новую задачу.
     */
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'completed' => 'boolean',
        'category_id' => 'nullable|exists:categories,id',
    ]);

    Task::create($request->all());

    return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
}

    /**
     * Показать одну задачу.
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Показать форму редактирования задачи.
     */
    public function edit(Task $task)
    {
        $categories = Category::all();
        return view('tasks.edit', compact('task', 'categories'));
    }
    

    /**
     * Обновить задачу.
     */
    public function update(Request $request, Task $task)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'completed' => 'boolean',
        'category_id' => 'nullable|exists:categories,id',
    ]);

    $task->update($request->all());

    return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
}


    /**
     * Удалить задачу.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
