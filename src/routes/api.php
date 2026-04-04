<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Tag\TagController;
use App\Http\Controllers\Task\TaskController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Project\ProjectController;

// Quando alguém acessar /users com o verbo GET, chame o método index do UserController
Route::get('/users', [UserController::class, 'index']);

/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
*/

/**
 * User
 */
Route::resource('users', UserController::class, ['except' => ['create', 'edit']]);

/**
 * Profile 
 */
Route::resource('profiles', ProfileController::class, ['only' => ['index', 'update']]);

/**
 * Tag
 */
Route::resource('tags', TagController::class, ['only' => ['index', 'store']]);

/**
 * Task
 */
Route::resource('projects.tasks', TaskController::class);

/**
 * Project
 */
Route::resource('projects', ProjectController::class);

/**
 * Para apagar o relacionamento entre Task e Tag, já que é uma relação muitos-para-muitos, precisamos de rotas específicas para isso.
 */
Route::post('/tasks/{taskId}/tags/{tagId}', [TaskController::class, 'attachTag']);
Route::delete('/tasks/{taskId}/tags/{tagId}', [TaskController::class, 'detachTag']);