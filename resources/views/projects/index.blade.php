<x-app-layout title="Projects">
    <div class="container">
        <div class="header">
            <h1>Projects</h1>
            <a class="link" href="{{ route('projects.create') }}">Start a New Project</a>
        </div>

        <div class="card">
            <div class="">
                <div class="grid divide-y divide-zinc-200 striped hover">
                    @foreach($projects as $project)
                        <div class="p-3 flex even:bg-zinc-100 md:items-center flex-col md:flex-row">
                            <div class="md:hidden truncate">
                                <a class="link whitespace-normal" href="{{ route('projects.show', $project) }}">
                                    {{ $project->id }} {{ $project->name }}
                                </a>
                            </div>
                            <a class="hidden md:inline truncate link" href="{{ route('projects.show', $project) }}">
                                {{ $project->id }} {{ $project->name }}
                            </a>

                            <div class="md:flex md:ml-4 md:space-x-5 items-center flex-wrap">
                                @if(!empty($project->team))
                                    <div class="text-sm" title="Team">{{ $project->team->name }}</div>
                                @endif

                                @if(!empty($project->owner))
                                    <div class="text-sm" title="Owner">{{ $project->owner->name }}</div>
                                @endif
                            </div>

                            <div class="mt-1 md:ml-auto flex space-x-3 md:justify-end items-center text-center">
                                @if($project->past_due_tasks_count > 0)
                                    <div class="badge text-xs text-center badge-danger" title="Incomplete Tasks">
                                        {{ $project->past_due_tasks_count }} Past Due
                                    </div>
                                @endif
                                @if($project->incomplete_tasks_count > 0)
                                    <div class="badge text-xs text-center badge-primary" title="Incomplete Tasks">
                                        {{ $project->incomplete_tasks_count }} Incomplete
                                    </div>
                                @endif
                                <div class="text-xs justify-end">
                                    <livewire:project-status-button :project="$project" />
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card-footer">
                {!! $projects->links() !!}
            </div>
        </div>



    </div>
</x-app-layout>
