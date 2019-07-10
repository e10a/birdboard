<div class="field my-6">
    <div class="control">
        <input
            name="title"
            type="text"
            class="input bg-transparent border border-gray-400 rounded p-2 text-xs w-full"
            placeholder="Title"
            value="{{ $project->title }}"
        >
    </div>
</div>
<div class="field my-6">
    <div class="control">
        <textarea
            name="description"
            rows="10"
            class="textarea bg-transparent border border-gray-400 rounded p-2 text-xs w-full"
            placeholder="Description"
        >{{ $project->description }}</textarea>
    </div>
</div>
<div class="field">
    <div class="control">
        <button type="submit" class="button is-link">{{ $buttonText }}</button>
        <a href="{{ $cancel }}">Cancel</a>
    </div>
</div>
