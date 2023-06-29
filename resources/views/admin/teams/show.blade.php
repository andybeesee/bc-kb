<x-app-layout title="Team">
    <div class="container">
        <h1>{{ $team->name }}</h1>
        <div class="sub-nav">
            <a class="link" href="{{ route('admin.teams.edit', $team) }}">Edit</a>
        </div>
    </div>
</x-app-layout>
