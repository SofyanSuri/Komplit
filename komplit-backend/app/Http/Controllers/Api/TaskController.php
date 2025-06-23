<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Project;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;
use App\Events\TaskUpdated;

class TaskController extends Controller
{
    public function index(Project $project)
    {
        $tasks = $project->tasks()->with(['assignee', 'kanbanState'])->get();
        return TaskResource::collection($tasks);
    }

    public function store(Request $request, Project $project)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'kanban_state_id' => 'required|exists:kanban_states,id',
            'assignee_id' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
            'order' => 'nullable|integer',
        ]);
        $data['created_by'] = $request->user()->id;
        $data['project_id'] = $project->id;
        $task = Task::create($data);
        if ($task->assignee_id) {
            $assignee = User::find($task->assignee_id);
            if ($assignee) {
                $assignee->notify(new TaskAssigned($task));
            }
        }
        return new TaskResource($task->load(['assignee', 'kanbanState']));
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);
        return new TaskResource($task->load(['assignee', 'kanbanState']));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'kanban_state_id' => 'sometimes|exists:kanban_states,id',
            'assignee_id' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
            'order' => 'nullable|integer',
        ]);
        $task->update($data);
        if (
            isset($data['assignee_id']) &&
            $data['assignee_id'] &&
            $data['assignee_id'] != $oldAssigneeId
        ) {
            $assignee = User::find($data['assignee_id']);
            if ($assignee) {
                $assignee->notify(new TaskAssigned($task));
            }
        }        
        event(new TaskUpdated($task));
        return new TaskResource($task->load(['assignee', 'kanbanState']));
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();
        return response()->noContent();
    }
}