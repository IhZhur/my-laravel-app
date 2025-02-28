<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;

Route::resource('categories', CategoryController::class);

Route::get('/debug', function () {
    dd(database_path('database.sqlite'));
});
Route::get('/debug-path', function () {
    return database_path('database.sqlite');
});
Route::get('/', function () {
    return view('app'); // Используется React
});

Route::get('/check-permissions', function () {
    $file = database_path('database.sqlite');
    if (is_writable($file)) {
        return 'Файл доступен для записи.';
    }
    return 'Файл недоступен для записи.';
});

Route::resource('tasks', TaskController::class);