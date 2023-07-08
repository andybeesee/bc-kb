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

                    <div class="ml-auto grid grid-cols-3 justify-end text-center gap-4">
                        <div>
                            @if($project->past_due_tasks_count > 0)
                                <div class="badge text-center badge-danger" title="Incomplete Tasks">
                                    {{ $project->past_due_tasks_count }} Past Due
                                </div>
                            @endif
                        </div>
                        <div>
                            @if($project->incomplete_tasks_count > 0)
                                <div class="badge text-center badge-primary" title="Incomplete Tasks">
                                    {{ $project->incomplete_tasks_count }} Incomplete
                                </div>
                            @endif
                        </div>

                            <livewire:project-status-button :project="$project" />
                    </div>
                </div>
            @endforeach
        </div>

        {!! $projects->links() !!}
    </div>
</x-app-layout>
