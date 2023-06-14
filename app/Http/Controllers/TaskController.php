<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function addTaskToProject(TaskRequest $request, $projectId)
    {
        $project = Project::findOrFail($projectId);
        $validated = $request->validated();

        $task = Task::addToProject($validated, $project);

        return response()->json(['message' => 'Task added to the project', 'task' => $task], 201);
    }

}
