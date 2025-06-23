<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KanbanStateResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'project_id'=> $this->project_id,
            'name'      => $this->name,
            'order'     => $this->order,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
        ];
    }
}