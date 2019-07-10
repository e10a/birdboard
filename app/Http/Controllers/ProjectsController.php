<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{
    public function index()
    {
        // $projects = Project::all();
        $projects = auth()->user()->projects;
        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $this->authorize('update', $project);

        $tasks = $project->tasks;

        return view('projects.show', compact('project', 'tasks'));
    }

    public function store()
    {
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required|max:100',
            'notes' => 'min:3'
        ]);
        $project = auth()->user()->projects()->create($attributes);
        return redirect($project->path());
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function update(Project $project)
    {
        // authorize user
        $this->authorize('update', $project);

        // validate
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required|max:100',
            'notes' => 'min:3'
        ]);

        // persist
        $project->update($attributes);

        // redirect
        return redirect($project->path());
    }
}
