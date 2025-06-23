<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = $request->user()->projects()->with('owner')->get();
        return ProjectResource::collection($projects);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $project = $request->user()->ownedProjects()->create($data);
        $project->members()->attach($request->user()->id, ['role' => 'owner']);
        return new ProjectResource($project->load('owner'));
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);
        
        return new ProjectResource($project->load('owner'));
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|string',
        ]);
        $project->update($data);
        return new ProjectResource($project->load('owner'));
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete();
        return response()->noContent();
    }
}