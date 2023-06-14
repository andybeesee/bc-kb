<x-app-layout title="Projects">
    <div class="container">
        <div class="header">
            <h1>Projects</h1>
            <a class="link" href="{{ route('projects.create') }}">Start a New Project</a>
        </div>

        <div class="list-group striped hover">
            @foreach($projects as $project)
                <div class="list-group-item">
                    <a class="link" href="{{ route('projects.show', $project) }}">
                        {{ $project->id }} {{ $project->name }}
                    </a>
                </div>
            @endforeach
        </div>

        {!! $projects->links() !!}
    </div>
</x-app-layout>
