<x-app-layout>
<div class="container">
    <h1>Dashboard</h1>

    <div class="grid grid-cols-2 gap-3">
        <div>
            <div class="card mb-5">
                <div class="card-title">
                    Your Teams
                    <p class="text-sm font-normal">These are teams you are on, click on the team to go to the team dashboard. Similar to your dashboard, but for the team.</p>
                </div>
                <div class="card-body">
                    @foreach($teams as $team)
                        <div class="p-1">
                            <a href="#" class="link">
                                {{ $team->name }}
                            </a>

                            {{--TODO: in progress projects count, incomplete task count, link to team page --}}
                        </div>
                    @endforeach
                </div>
            </div>

            @if($currentProjects->count() > 0)
                <div class="card mb-5">
                    <div class="card-title">
                        Your Current Projects
                        <p class="font-normal text-sm">These are projects you are in charge of moving forward and accountable for. Does not include completed projects, or 'idea' projects</p>
                    </div>
                    <div class="card-body">
                        <div>
                            {{--TODO: list projects with incomplete task count, due date --}}
                            @foreach($currentProjects as $currentProject)
                                <div class="p-1">
                                    <a class="link" href="{{ route('projects.show', $currentProject) }}">
                                        {{ $currentProject->name }}
                                    </a>
                                    <span class="text-sm">{{ $currentProject->status }}</span>

                                    <span class="text-sm">{{ $currentProject->team?->name }}</span>

                                    <div>
                                        {{--TODO: last update goes here --}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div><!-- end of current project list -->
            @endif

            @if($pastDueTasks->count() > 0)
                <div class="card mb-5">
                    <div class="card-title bg-red-800 text-white">
                        Past Due Tasks
                        <p class="text-sm font-normal">Does not include tasks from completed, abandoned or 'idea' projects</p>
                    </div>
                    <div class="grid divide-y divide-zinc-300">
                        @foreach($pastDueTasks as $pastDueTask)
                            <div class="p-2 hover:bg-zinc-50 dark:hover:bg-zinc-900">
                                <div class="flex items-center">
                                    {{--TODO: We want complete toggle here --}}
                                    {{ $pastDueTask->name }}

                                    @if($pastDueTask->due_date)
                                        <span class="ml-3 {{ $pastDueTask->isLate ? 'text-red-700' : '' }}">
                                            {{ $pastDueTask->due_date->format(config('app.date_display')) }}
                                        </span>
                                    @endif
                                </div>
                                <div class="text-xs">
                                    <a class="link" title="Go to project" href="{{ route('projects.show', $pastDueTask->project) }}">
                                        {{ $pastDueTask->project->name }}
                                    </a>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div><!-- end of past due task list -->
            @endif
        </div><!-- end of column 1 -->
        <div>
            @if($upcomingDueTasks->count() > 0)
                <div class="card mb-5">
                    <div class="card-title">
                        Upcoming Tasks
                        <p class="text-sm font-normal">Does not include tasks from completed, abandoned or 'idea' projects</p>
                    </div>
                    <div class="grid divide-y divide-zinc-300">
                        @foreach($upcomingDueTasks as $dueTask)
                            <div class="p-2 hover:bg-zinc-50">
                                <div class="flex items-center">
                                    {{--TODO: We want complete toggle here --}}
                                    {{ $dueTask->name }}

                                    @if($dueTask->due_date)
                                        <span class="ml-3 {{ $dueTask->isLate ? 'text-red-700' : '' }}">
                                            {{ $dueTask->due_date->format(config('app.date_display')) }}
                                        </span>
                                    @endif
                                </div>
                                <div class="text-xs">
                                    <a class="link" title="Go to project" href="{{ route('projects.show', $dueTask->project) }}">
                                        {{ $dueTask->project->name }}
                                    </a>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div><!-- end of upcoming task card -->
            @endif

            <div class="card">
                <div class="card-title">
                    Incomplete Tasks, Without Due Dates Assigned to You
                    <p class="text-sm font-normal">Does not include tasks from completed, abandoned or 'idea' projects</p>
                </div>
                <div class="grid divide-y divide-zinc-300">
                    @foreach($incompleteTasks as $incompleteTask)
                        <div class="p-2 hover:bg-zinc-50 dark:hover:bg-zinc-900">
                            <div class="flex items-center">
                                {{--TODO: We want complete toggle here --}}
                                {{ $incompleteTask->name }}

                                @if($incompleteTask->due_date)
                                    <span class="ml-3">
                                    {{ $incompleteTask->due_date->format(config('app.date_display')) }}
                                </span>
                                @endif
                            </div>
                            <div class="text-xs">
                                <a class="link" title="Go to project" href="{{ route('projects.show', $incompleteTask->project) }}">
                                    {{ $incompleteTask->project->name }}
                                </a>
                            </div>

                        </div>
                    @endforeach
                </div>
                {{--TODO: list tasks and show project/board info --}}
            </div><!-- end of incomplete task card -->
        </div>
    </div>
</div>
</x-app-layout>
