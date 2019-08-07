<div class="card flex flex-col" style="height: 200px;">
    <h3 class="font-normal text-xl mb-3 p-4 border-l-4 -mx-5 border-blue-light">
        <a href="{{ $project->path() }}" class="text-black no-underline">{{ $project->title }}</a>
    </h3>
    <div class="text-gray-600 flex-1">{{ str_limit($project->description, 20) }}</div>
    <footer>
        <form method="POST" action="{{ $project->path() }}" class="text-right">
            @method('DELETE')
            @csrf
            <button type="submit" class="text-xs">Delete</button>
        </form>
    </footer>
</div>
