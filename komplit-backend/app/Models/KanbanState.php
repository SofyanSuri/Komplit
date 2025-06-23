<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KanbanState extends Model
{
    protected $fillable = [
        'project_id', 'name', 'order'
    ];

    // The project this state belongs to
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Tasks in this state
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}