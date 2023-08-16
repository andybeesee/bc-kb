<div class="grid md:grid-cols-2 items-start gap-4">
    @if($currentProjects->count() > 0)
        <div class="card">
            <div class="card-body">
                <div class="font-bold text-lg mb-3">{{ $currentProjects->count() }} Current Projects</div>
                <div class="grid">
                    @foreach($currentProjects as $project)
                        <button wire:click="$set('projectId', {{ $project->id }})" type="button" class="text-left underline hover:text-blue-600">
                            {{ $project->name }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    @if($pastDueTasks->count() > 0)
        <div class="card">
            <div class="card-body">
                <div class="font-bold text-lg text-red-700 dark:text-red-400 mb-3">{{ $pastDueTasks->count() }} Past Due Tasks</div>
                <div class="grid">
                    @foreach($pastDueTasks as $task)
                        <button wire:click="$set('projectId', {{ $task->project_id }})" type="button" class="text-left hover:text-blue-600">
                            {{ $task->name }} <small>({{ $task->project->name }})</small>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    @if($upcomingDueTasks->count() > 0)
        <div class="card">
            <div class="card-body">
                <div class="font-bold text-lg mb-3">{{ $upcomingDueTasks->count() }} Upcoming Tasks</div>
                <div class="grid">
                    @foreach($upcomingDueTasks as $task)
                        <button wire:click="$set('projectId', {{ $task->project_id }})" type="button" class="text-left hover:text-blue-600">
                            {{ $task->name }} <small>({{ $task->project->name }})</small>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    @if($incompleteTasks->count() > 0)
        <div class="card">
            <div class="card-body">
                <div class="font-bold text-lg mb-3">{{ $incompleteTasks->count() }} Incomplete Tasks</div>
                <div class="grid">
                    @foreach($incompleteTasks as $task)
                        <button wire:click="$set('projectId', {{ $task->project_id }})" type="button" class="text-left hover:text-blue-600">
                            {{ $task->name }} <small>({{ $task->project->name }})</small>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
