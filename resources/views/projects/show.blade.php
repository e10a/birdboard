@extends('layouts.app')
@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex w-full items-end justify-between">
        <p class="text-gray-600 text-sm">
            <a
            class="text-gray-600 no-underline"
            href="/projects">My Projects</a> / {{ $project->title }}
        </p>
        <p>{{ $project->description }}</p>
        <a href="{{ $project->path() . '/edit' }}" class="button">Edit Project</a>
        </div>
    </header>

    <main class="lg:flex -mx-3">
        <div class="lg:w-3/4 px-3">
            <div class="mb-8">
                <h2 class="text-lg text-gray-600 font-normal mb-3">Tasks</h2>
                @foreach ($project->tasks as $task)
                    <div class="card mb-3">
                        <form method="POST" action="{{ $task->path() }}">
                            @method('PATCH')
                            @csrf
                            <div class="flex">
                                <input
                                    type="text"
                                    placeholder="Add a new task..."
                                    class="w-full {{ $task->completed ? 'text-gray-400' : '' }}"
                                    name="body"
                                    value="{{ $task->body }}"
                                />
                                <input
                                    type="checkbox"
                                    name="completed"
                                    onChange="this.form.submit()"
                                    {{ $task->completed ? 'checked' : '' }}
                                />
                            </div>
                        </form>
                    </div>
                @endforeach
                <div class="card mb-3">
                    <form method="POST" action="{{ $project->path() . '/tasks' }}">
                        @csrf
                        <input
                            type="text"
                            placeholder="Add a new task..."
                            class="w-full"
                            name="body"
                        >
                    </form>
                </div>
            </div>
            <div>
                <h2 class="text-lg text-gray-600 font-normal mb-3">General Notes</h2>
                <form method="POST" action="{{ $project->path() }}">
                    @method('PATCH')
                    @csrf
                    <textarea
                        name="notes"
                        class="card w-full"
                        placeholder="Add notes..."
                        style="min-height: 200px;"
                    >{{ $project->notes }}</textarea>
                    <button type="submit" class="button">Save</button>
                </form>
            </div>
        </div>
        <div class="lg:w-1/4 px-3">
            @include ('projects.card')
            @include ('projects.activity.card')
        </div>
    </main>
@endsection
