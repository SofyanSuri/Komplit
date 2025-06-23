<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('project.{projectId}', function ($user, $projectId) {
    // Only allow project members
    return $user->projects()->where('project_id', $projectId)->exists();
});