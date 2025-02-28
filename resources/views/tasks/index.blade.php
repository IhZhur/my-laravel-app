@extends('layouts.app')

@section('title', 'Task List')

@section('content')
    <h1>Task List</h1>

    <!-- Сообщение об успехе -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Панель управления -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('tasks.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Search tasks:</label>
                    <input type="text" id="search" name="search" class="form-control" placeholder="Search tasks..." value="{{ request('search') }}">
                </div>

                <div class="col-md-4">
                    <label for="category_id" class="form-label">Category:</label>
                    <select id="category_id" name="category_id" class="form-select">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Search</button>
                    <a href="{{ route('tasks.create') }}" class="btn btn-success me-2">Create Task</a>
                    <!-- Кнопка для открытия модального окна добавления категории -->
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                        Add Category
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Таблица задач -->
    @if ($tasks->isEmpty())
        <div class="alert alert-warning">No tasks available.</div>
    @else
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>
                        <a href="{{ route('tasks.index', ['sortBy' => 'id', 'sortOrder' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}">
                            ID @if ($sortBy === 'id') ({{ $sortOrder }}) @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ route('tasks.index', ['sortBy' => 'title', 'sortOrder' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}">
                            Title @if ($sortBy === 'title') ({{ $sortOrder }}) @endif
                        </a>
                    </th>
                    <th>Description</th>
                    <th>
                        <a href="{{ route('tasks.index', ['sortBy' => 'category_id', 'sortOrder' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}">
                            Category @if ($sortBy === 'category_id') ({{ $sortOrder }}) @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ route('tasks.index', ['sortBy' => 'completed', 'sortOrder' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}">
                            Completed @if ($sortBy === 'completed') ({{ $sortOrder }}) @endif
                        </a>
                    </th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->category->name ?? 'No Category' }}</td>
                        <td>{{ $task->completed ? 'Yes' : 'No' }}</td>
                        <td>
                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm" onclick="openDeleteModal('{{ route('tasks.destroy', $task->id) }}')">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="d-flex justify-content-between align-items-center">
    <div>
        <!-- Текст о количестве отображаемых результатов -->
        <p class="text-muted mb-0">
            Showing {{ $tasks->firstItem() }} to {{ $tasks->lastItem() }} of {{ $tasks->total() }} results
        </p>
    </div>
    <div>
        <!-- Упрощённая пагинация -->
        {{ $tasks->onEachSide(1)->links('vendor.pagination.simple-default') }}
    </div>
    </div>


    <!-- Модальное окно для добавления категории -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Скрипт для управления модальным окном -->
    <script>
        function openDeleteModal(action) {
            const form = document.getElementById('deleteForm');
            form.action = action;
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }
    </script>
@endsection
@push('styles')
<style>
    /* Уменьшаем размеры стрелок */
    .pagination .w-5.h-5 {
        width: 12px !important; /* Принудительный размер */
        height: 12px !important; /* Принудительный размер */
    }

    /* Уменьшаем кнопки пагинации */
    .pagination .page-link {
        font-size: 0.85rem; /* Размер текста */
        padding: 0.25rem 0.5rem; /* Уменьшенные отступы */
    }

    /* Центрирование пагинации */
    .pagination {
        justify-content: center;
    }
</style>
@endpush