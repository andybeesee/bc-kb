<x-app-layout title="Project Detail">
    <div class="container">
        <h1>{{ $project->name }}</h1>

        <div>
            <div class="mb-5">
                 <div class="sub-nav">
                    <a class="link" href="{{ route('projects.show', $project) }}" data-exact-active="y">Detail</a>
                    <a class="link" href="{{ route('projects.edit', $project) }}">Edit</a>
                    <a class="link" href="{{ route('projects.boards.create', $project) }}">Add a Board</a>
                </div>
            </div>

            {{ $slot }}
    </div>
</x-app-layout>
