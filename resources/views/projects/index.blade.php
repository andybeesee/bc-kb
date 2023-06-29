<x-app-layout title="Projects">
    <div class="container">
        <div class="header">
            <h1>Projects</h1>
            <a class="link" href="{{ route('projects.create') }}">Start a New Project</a>
        </div>

        <div class="list-group striped hover">
            @foreach($projects as $project)
                <div class="list-group-item flex md:items-center flex-col md:flex-row">
                    <a class="link" href="{{ route('projects.show', $project) }}">
                        {{ $project->id }} {{ $project->name }}
                    </a>
                    <span class="md:hidden status-badge {{ $project->status }}" title="Status">{{ config('statuses.'.$project->status) }}</span>
                    @if(!empty($project->team))
                        <span title="Team">{{ $project->team->name }}</span>
                    @endif

                    @if(!empty($project->owner))
                        <span title="Owner">{{ $project->owner->name }}</span>
                    @endif
                    <span class="hidden md:block md:ml-auto status-badge {{ $project->status }}" title="Status">{{ config('statuses.'.$project->status) }}</span>
                </div>
            @endforeach
        </div>

        {!! $projects->links() !!}
    </div>
</x-app-layout>
