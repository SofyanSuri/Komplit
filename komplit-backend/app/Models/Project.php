<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name', 'description', 'owner_id', 'status'
    ];

    // Owner of the project
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // Members of the project
    public function members()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('role', 'joined_at')
            ->withTimestamps();
    }

    // Kanban states for this project
    public function kanbanStates()
    {
        return $this->hasMany(KanbanState::class);
    }

    // Tasks in this project
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}