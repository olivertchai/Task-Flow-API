<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Tag\TagController;
use App\Http\Controllers\Task\TaskController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\AuthController;

/**
 * AuthController 
 */

// Rotas PÚBLICAS (Qualquer um acessa sem token)
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Rotas PROTEGIDAS (O "Segurança" bloqueia quem não tem o Token)
Route::middleware('auth:sanctum')->group(function() {
    // Suas rotas de Tasks que arrumamos antes ficam todas aqui dentro!
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::post('/tasks/{taskId}/tags/{tagId}', [TaskController::class, 'attachTag']);
    Route::delete('/tasks/{taskId}/tags/{tagId}', [TaskController::class, 'detachTag']);

    // Rotas Protegidas Tag
    Route::get('/tags', [TagController::class, 'index']);
    Route::post('/tags', [TagController::class, 'store']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});

/**
 * User
 */
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('users', UserController::class, ['except' => [ 'edit']]);

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