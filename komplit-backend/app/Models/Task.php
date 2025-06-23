<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'project_id', 'title', 'description', 'kanban_state_id',
        'assignee_id', 'due_date', 'order', 'created_by'
    ];

    // The project this task belongs to
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // The Kanban state (column) this task is in
    public function kanbanState()
    {
        return $this->belongsTo(KanbanState::class);
    }

    // The user assigned to this task
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    // The user who created this task
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}