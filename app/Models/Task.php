<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function addToProject(array $data, Project $project): Task
    {
        $task = new Task([
            'title' => $data['title'],
            'description' => $data['description'],
            'due_date' => $data['due_date'],
            'priority' => $data['priority'],
            'completed' => $data['completed'] ?? false,
        ]);

        $project->tasks()->save($task);

        return $task;
    }

}
