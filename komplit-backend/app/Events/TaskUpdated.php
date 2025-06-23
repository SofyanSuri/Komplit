<?php

namespace App\Events;

use App\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class TaskUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task->load(['assignee', 'kanbanState']);
    }

    public function broadcastOn()
    {
        // Private channel for the project
        return new PrivateChannel('project.' . $this->task->project_id);
    }

    public function broadcastWith()
    {
        return [
            'task' => $this->task->toArray(),
        ];
    }
}