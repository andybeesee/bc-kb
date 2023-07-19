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
