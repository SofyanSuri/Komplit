<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'project_id'     => $this->project_id,
            'title'          => $this->title,
            'description'    => $this->description,
            'kanban_state'   => new KanbanStateResource($this->whenLoaded('kanbanState')),
            'assignee'       => new UserResource($this->whenLoaded('assignee')),
            'due_date'       => $this->due_date,
            'order'          => $this->order,
            'created_by'     => $this->created_by,
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
        ];
    }
}