<div class="card flex flex-col mt-3" style="min-height: 200px;">
    <h3 class="font-normal text-xl mb-3 p-4 border-l-4 -mx-5 border-blue-light">
        Invite a User
    </h3>
    <form method="POST" action="{{ $project->path() . '/invitations' }}">
        @csrf
        <div class="mb-3">
            <input
                type="email"
                name="email"
                class="border border-gray-400 rounded w-full py-2 px-3"
                placeholder="Email address"
            />
        </div>
        <button type="submit" class="button">Invite</button>
    </form>
    @include('errors', [ 'bag' => 'invitations' ])
</div>
