@extends('layouts.app')
@section('content')
    <h1>Create a Project</h1>
    <form method="POST" action="/projects">
        @csrf
        <div class="field">
            <div class="control">
                <input name="title" type="text" class="input" placeholder="Title">
            </div>
        </div>
        <div class="field">
            <div class="control">
                <textarea name="description" id="" cols="30" rows="10" class="textarea" placeholder="Description"></textarea>
            </div>
        </div>
        <div class="field">
            <div class="control">
                <button type="submit" class="button is-link">Create Project</button>
                <a href="/projects">Cancel</a>
            </div>
        </div>
    </form>
@endsection
