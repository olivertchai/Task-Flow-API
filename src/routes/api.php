<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Tag\TagController;
use App\Http\Controllers\Task\TaskController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\AuthController; // Ajustado o namespace se você moveu para a pasta Auth

// -----------------------------------------------------------------------------
// ROTAS PÚBLICAS (Qualquer um acessa sem token)
// -----------------------------------------------------------------------------
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::resource('users', UserController::class, ['except' => ['create', 'edit']]);
Route::resource('profiles', ProfileController::class, ['only' => ['index', 'update']]);
Route::resource('projects', ProjectController::class);
Route::resource('projects.tasks', TaskController::class);

// -----------------------------------------------------------------------------
// ROTAS PROTEGIDAS (O "Segurança" bloqueia quem não tem o Token)
// -----------------------------------------------------------------------------
Route::middleware('auth:sanctum')->group(function() {
    
    // Rota de usuário logado
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Rotas de Tags (Corrigido para usar o TagController e removido o Route::resource solto lá de baixo)
    Route::get('/tags', [TagController::class, 'index']);
    Route::post('/tags', [TagController::class, 'store']);

    // Rotas de Tasks (Isoladas)
    Route::get('/tasks', [TaskController::class, 'index']);

    // Rotas de Relacionamento Task <-> Tag (Removida a duplicata do final do arquivo)
    Route::post('/tasks/{taskId}/tags/{tagId}', [TaskController::class, 'attachTag']);
    Route::delete('/tasks/{taskId}/tags/{tagId}', [TaskController::class, 'detachTag']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});