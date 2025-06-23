<?php

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\KanbanStateController;

Route::middleware('auth:sanctum')->group(function () {
    // Projects
    Route::apiResource('projects', ProjectController::class);

    // Kanban States (nested under projects)
    Route::get('projects/{project}/kanban-states', [KanbanStateController::class, 'index']);
    Route::post('projects/{project}/kanban-states', [KanbanStateController::class, 'store']);
    Route::put('kanban-states/{kanban_state}', [KanbanStateController::class, 'update']);
    Route::delete('kanban-states/{kanban_state}', [KanbanStateController::class, 'destroy']);

    // Tasks (nested under projects)
    Route::get('projects/{project}/tasks', [TaskController::class, 'index']);
    Route::post('projects/{project}/tasks', [TaskController::class, 'store']);
    Route::get('tasks/{task}', [TaskController::class, 'show']);
    Route::put('tasks/{task}', [TaskController::class, 'update']);
    Route::delete('tasks/{task}', [TaskController::class, 'destroy']);
});