<x-app-layout title="Editing Team">
    <div class="container">
        <div class="mb-6">
            <h1>Teams</h1>
            <a class="link" href="{{ route('admin.teams.create') }}">Add a Team</a>
        </div>

        <div class="list-group">
            @foreach($teams as $team)
                <div class="list-group-item hover:bg-zinc-50">
                    <a class="link" href="{{ route('admin.teams.show', $team) }}">
                        {{ $team->name }}
                    </a>

                    <span class="text-sm block md:ml-2 md:inline">{{ $team->members_count }} members</span>

                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
