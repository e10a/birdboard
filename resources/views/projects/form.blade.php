<div class="field my-6">
    <div class="control">
        <input
            name="title"
            required
            type="text"
            class="input bg-transparent border border-gray-400 rounded p-2 text-xs w-full {{ $errors->has('title') ? 'border-red-400' : '' }}"
            placeholder="Title"
            value="{{ $project->title }}"
        >
    </div>
</div>
<div class="field my-6">
    <div class="control">
        <textarea
            name="description"
            required
            rows="10"
            class="textarea bg-transparent border border-gray-400 rounded p-2 text-xs w-full {{ $errors->has('description') ? 'border-red-400' : '' }}"
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

@include ('errors')
