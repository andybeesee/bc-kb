<div class="mx-1 md:mx-6 lg:mx-10 grid grid-cols-4 gap-8 items-start">
    <div>
        <div class="mb-3">
            <x-form.input
                type="text" p
                laceholder="Search"
                class="p-1 text-sm"
                name="project_search"
                wire:model="projectSearch"
            />
        </div>
        <div class="grid">
            <button
                wire:click.self="$set('projectId', null)"
                class="cursor-pointer text-sm p-2 flex truncate items-center rounded-md {{ empty($projectId) ? 'bg-purple-100 dark:bg-purple-700 hover:bg-purple-200 dark:hover:bg-purple-800' : 'hover:bg-zinc-100 hover:bg-zinc-700' }}"
                title="Show dashboard"
            >
                Dashboard
            </button>
            @foreach($this->projects as $project)
                <button type="button"
                    wire:click.self="$set('projectId', {{$project->id}})"
                    class="cursor-pointer text-sm p-2 flex truncate items-center rounded-md {{ $project->id === $projectId ? 'bg-purple-100 dark:bg-purple-700 hover:bg-purple-200 dark:hover:bg-purple-800' : 'hover:bg-zinc-100 hover:bg-zinc-700' }}"
                    title="{{ $project->name }} -- {{ $project->status }}"
                >
                    {{ $project->name }}
                </button>
            @endforeach
        </div>
    </div>
    <div class="col-span-3">
        @if(empty($projectId))
            <div class="grid md:grid-cols-2 items-start gap-4">
                @if($dashboardData['currentProjects']->count() > 0)
                    <div class="card">
                        <div class="card-body">
                            <div class="font-bold text-lg mb-3">{{ $dashboardData['currentProjects']->count() }} Current Projects</div>
                            <div class="grid">
                                @foreach($dashboardData['currentProjects'] as $project)
                                    <button wire:click="$set('projectId', {{ $project->id }})" type="button" class="text-left underline hover:text-blue-600">
                                        {{ $project->name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                @if($dashboardData['pastDueTasks']->count() > 0)
                    <div class="card">
                        <div class="card-body">
                            <div class="font-bold text-lg text-red-700 dark:text-red-400 mb-3">{{ $dashboardData['pastDueTasks']->count() }} Past Due Tasks</div>
                            <div class="grid">
                                @foreach($dashboardData['pastDueTasks'] as $task)
                                    <button wire:click="$set('projectId', {{ $task->project_id }})" type="button" class="text-left hover:text-blue-600">
                                        {{ $task->name }} <small>({{ $task->project->name }})</small>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                @if($dashboardData['upcomingDueTasks']->count() > 0)
                    <div class="card">
                        <div class="card-body">
                            <div class="font-bold text-lg mb-3">{{ $dashboardData['upcomingDueTasks']->count() }} Upcoming Tasks</div>
                            <div class="grid">
                                @foreach($dashboardData['upcomingDueTasks'] as $task)
                                    <button wire:click="$set('projectId', {{ $task->project_id }})" type="button" class="text-left hover:text-blue-600">
                                        {{ $task->name }} <small>({{ $task->project->name }})</small>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                @if($dashboardData['incompleteTasks']->count() > 0)
                    <div class="card">
                        <div class="card-body">
                            <div class="font-bold text-lg mb-3">{{ $dashboardData['incompleteTasks']->count() }} Incomplete Tasks</div>
                            <div class="grid">
                                @foreach($dashboardData['incompleteTasks'] as $task)
                                    <button wire:click="$set('projectId', {{ $task->project_id }})" type="button" class="text-left hover:text-blue-600">
                                        {{ $task->name }} <small>({{ $task->project->name }})</small>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @else
            <livewire:project-detail-page :project-id="$projectId" wire:key="container-project-detail-{{ $projectId }}" />
        @endif
    </div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
</div>
