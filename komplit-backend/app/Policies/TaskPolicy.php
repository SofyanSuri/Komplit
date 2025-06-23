<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    // Can view if user is a project member or admin
    public function view(User $user, Task $task)
    {
        return $user->id === $task->project->owner_id
            || $task->project->members->contains($user->id)
            || $user->hasRole('admin');
    }

    // Can update if assigned, creator, project_manager, or admin
    public function update(User $user, Task $task)
    {
        return $user->id === $task->assignee_id
            || $user->id === $task->created_by
            || ($task->project->members()->where('user_id', $user->id)->wherePivot('role', 'project_manager')->exists())
            || $user->hasRole('admin');
    }

    // Can delete if creator, project_manager, or admin
    public function delete(User $user, Task $task)
    {
        return $user->id === $task->created_by
            || ($task->project->members()->where('user_id', $user->id)->wherePivot('role', 'project_manager')->exists())
            || $user->hasRole('admin');
    }
}