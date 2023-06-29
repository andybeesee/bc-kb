<x-app-layout title="Projects">
    <div class="container">
        <div class="header">
            <h1>Projects</h1>
            <a class="link" href="{{ route('projects.create') }}">Start a New Project</a>
        </div>

        <div class="list-group striped hover">
            @foreach($projects as $project)
                <div class="list-group-item flex md:items-center flex-col md:flex-row">
                    <div class="md:hidden">
                        <a class="truncate link" href="{{ route('projects.show', $project) }}">
                            {{ $project->id }} {{ $project->name }}
                        </a>
                        <br>
                        <span class="md:hidden truncate status-badge {{ $project->status }}" title="Status">{{ config('statuses.'.$project->status) }}</span>
                    </div>
                    <a class="hidden md:inline truncate link" href="{{ route('projects.show', $project) }}">
                        {{ $project->id }} {{ $project->name }}
                    </a>
                    @if(!empty($project->team))
                        <span class="md:ml-3 text-sm" title="Team">{{ $project->team->name }}</span>
                    @endif

                    @if(!empty($project->owner))
                        <span class="md:ml-3 text-sm" title="Owner">{{ $project->owner->name }}</span>
                    @endif
                    <span class="hidden md:block md:ml-auto status-badge {{ $project->status }}" title="Status">{{ config('statuses.'.$project->status) }}</span>
                </div>
            @endforeach
        </div>

        {!! $projects->links() !!}
    </div>
</x-app-layout>
