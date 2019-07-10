@extends('layouts.app')
@section('content')
    <div class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
        <h1>Create a Project</h1>
        <form method="POST" action="/projects">
            @csrf
            @method('PATCH')
            @include('projects.form', [
                'project' => new App\Project,
                'buttonText' => 'Create Project',
                'cancel' => '/projects'
            ])
        </form>
    </div>
@endsection
