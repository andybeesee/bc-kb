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

                    <span class="flex flex-col md:flex-row md:inline-flex text-sm md:ml-2 truncate md:space-x-4">
                        <span title="Status">{{ str($project->status)->title() }}</span>
                        @if(!empty($project->team))
                            <span title="Team">{{ $project->team->name }}</span>
                        @endif

                        @if(!empty($project->owner))
                            <span title="Owner">{{ $project->owner->name }}</span>
                        @endif
                    </span>
                </div>
            @endforeach
        </div>

        {!! $projects->links() !!}
    </div>
</x-app-layout>
