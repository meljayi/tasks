<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProjectController extends Controller
{

    /**
     * fetch all projects.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $projects = Project::all();
        return response()->json(['projects' => $projects], 200);
    }

    /**
     * fetch details of a single project.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $project = Project::findOrFail($id);

        return response()->json(['project' => $project], 200);
    }

    /**
     * create a new project.
     *
     * @param  ProjectRequest  $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(ProjectRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $project = Project::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        return response()->json(['project' => $project], 201);
    }

    /**
     * update an existing project.
     *
     * @param  ProjectRequest  $request
     * @param  int  $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(ProjectRequest $request, int $id): JsonResponse
    {

        $validated = $request->validated();

        $project = Project::findOrFail($id);
        $project->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        return response()->json(['project' => $project], 200);

    }

    /**
     * Supprime un projet.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return response()->json(['message' => 'Project deleted successfully'], 200);
    }

    /**
     * get auth user projects.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function userProjects(Request $request): JsonResponse
    {
        $user = $request->user();
        $projects = Project::getUserProjects($user->id);
        return response()->json(['projects' => $projects], 200);
    }
}
