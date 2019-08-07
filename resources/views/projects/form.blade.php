<div class="field my-6">
    <div class="control">
        <input
            name="title"
            required
            type="text"
            class="input p-2 text-xs {{ $errors->has('title') ? 'border-red-400' : '' }}"
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
            class="input textarea p-2 text-xs {{ $errors->has('description') ? 'border-red-400' : '' }}"
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
