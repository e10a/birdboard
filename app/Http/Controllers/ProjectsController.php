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
        // $project = Project::findOrFail(request('project'));
        // if (auth()->id() !== (int) $project->owner_id) {
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }

        $tasks = $project->tasks;

        return view('projects.show', compact('project', 'tasks'));
    }

    public function store()
    {
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required'
        ]);
        // $attributes['owner_id'] = auth()->id();
        // Project::create($attributes);
        $project = auth()->user()->projects()->create($attributes);
        return redirect($project->path());
    }

    public function create()
    {
        return view('projects.create');
    }
}
