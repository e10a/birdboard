@if ($errors->{ $bag ?? 'default' }->any())
<div class="field mt-6">
    <ul class="list-reset">
    @foreach ($errors->{ $bag ?? 'default' }->all() as $error)
        <li class="my-1 text-sm text-red-600">{{ $error }}</li>
    @endforeach
    </ul>
</div>
@endif
