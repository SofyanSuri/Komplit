<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KanbanStateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\KanbanState;
use App\Http\Resources\KanbanStateResource;
use Illuminate\Http\Request;

class KanbanStateController extends Controller
{
    public function index(Project $project)
    {
        $states = $project->kanbanStates()->orderBy('order')->get();
        return KanbanStateResource::collection($states);
    }

    public function store(Request $request, Project $project)
    {
        $this->authorize('update', $project);
        
        $data = $request->validate([
            'name' => 'required|string|max:50',
            'order' => 'required|integer',
        ]);
        $data['project_id'] = $project->id;
        $state = KanbanState::create($data);
        return new KanbanStateResource($state);
    }

    public function update(Request $request, KanbanState $kanbanState)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:50',
            'order' => 'sometimes|integer',
        ]);
        $kanbanState->update($data);
        return new KanbanStateResource($kanbanState);
    }

    public function destroy(KanbanState $kanbanState)
    {
        $kanbanState->delete();
        return response()->noContent();
    }
}