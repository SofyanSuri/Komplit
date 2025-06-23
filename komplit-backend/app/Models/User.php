<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'fcm_token'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Relationships

    // Projects owned by the user
    public function ownedProjects()
    {
        return $this->hasMany(Project::class, 'owner_id');
    }

    // Projects the user is a member of
    public function projects()
    {
        return $this->belongsToMany(Project::class)
            ->withPivot('role', 'joined_at')
            ->withTimestamps();
    }

    // Tasks assigned to the user
    public function assignedTasks()
    {
        return $this->hasMany(Task::class, 'assignee_id');
    }

    // Tasks created by the user
    public function createdTasks()
    {
        return $this->hasMany(Task::class, 'created_by');
    }
}