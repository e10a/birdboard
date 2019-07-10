@if ($errors->any())
<div class="field mt-6">
    <ul>
    @foreach ($errors->all() as $error)
        <li class="my-1 text-sm text-red-600">{{ $error }}</li>
    @endforeach
    </ul>
</div>
@endif
