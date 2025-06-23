<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    // Can view if user is a member or owner
    public function view(User $user, Project $project)
    {
        return $user->id === $project->owner_id
            || $project->members->contains($user->id)
            || $user->hasRole('admin');
    }

    // Can update if owner, project_manager, or admin
    public function update(User $user, Project $project)
    {
        return $user->id === $project->owner_id
            || ($project->members()->where('user_id', $user->id)->wherePivot('role', 'project_manager')->exists())
            || $user->hasRole('admin');
    }

    // Can delete if owner or admin
    public function delete(User $user, Project $project)
    {
        return $user->id === $project->owner_id
            || $user->hasRole('admin');
    }
}