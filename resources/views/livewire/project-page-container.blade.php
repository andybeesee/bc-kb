<div class="mx-1 md:mx-6 lg:mx-10 grid grid-cols-4 gap-8 items-start">
    <div>
        <div class="grid">
            <button
                wire:click.self="$set('projectId', null)"
                class="w-full cursor-pointer text-sm p-2 flex truncate items-center rounded-md {{ empty($projectId) ? 'bg-purple-100 dark:bg-purple-700 hover:bg-purple-200 dark:hover:bg-purple-800' : 'hover:bg-zinc-100 hover:bg-zinc-700' }}"
                title="Show dashboard"
            >
                Dashboard
            </button>

            <div class="mt-3">
                <x-form.input
                    type="text" p
                    laceholder="Search"
                    class="p-1 text-sm"
                    name="project_search"
                    placeholder="Search all projects"
                    wire:model="projectSearch"
                />
            </div>
            <div x-data="{ open: false }">
                <button yype="button" class="p-2 text-left flex items-center text-sm" @click="open = !open">
                    <x-icon icon="caret-right" x-show="!open" class="h-4 w-4 mr-1" />
                    <x-icon icon="caret-down" x-show="open" class="h-4 w-4 mr-1" />
                    Projects to Show
                </button>
                <div class="ml-4 bg-zinc-100 dark:bg-zinc-700  text-sm" x-show="open">
                    <button type="button" class="w-full text-left p-2 {{ $projectList === 'user' && $userId === auth()->user()->id ? 'bg-purple-200 dark:bg-purple-700' : '' }}" wire:click="showUserProjects({{ auth()->user()->id }})">
                        Show Your Projects
                    </button>

                    <button type="button" class="w-full text-left p-2 {{ $projectList === 'team' && empty($teamId) ? 'bg-purple-200 dark:bg-purple-700' : '' }}" wire:click="showTeamProjects(null)">
                        Show Projects From Your Teams
                    </button>
                    <div x-data="{ open: false }">
                        <button class="text-left p-2 flex items-center" type="button" @click="open = !open">
                            <x-icon icon="caret-right" x-show="!open" class="h-4 w-4 mr-1" />
                            <x-icon icon="caret-down" x-show="open" class="h-4 w-4 mr-1" />
                            Show Team's Projects
                        </button>
                        <div class="grid border-l pl-3 ml-4 max-h-[350px] overflow-y-scroll" x-show="open">
                            <div class="my-2 sticky top-0 bg-zinc-100 dark:bg-zinc-700 font-bold mb-0">Your Teams</div>
                            @foreach($userTeams as $uTeam)
                                <button class="text-left p-1 rounded hover:bg-zinc-700 {{ $uTeam->id === $teamId ? 'bg-purple-200 dark:bg-purple-700' : '' }}" type="button" wire:click="showTeamProjects({{$uTeam->id}})">
                                    {{ $uTeam->name }}
                                </button>
                            @endforeach
                            <div class="my-2 sticky top-0 bg-zinc-100 dark:bg-zinc-700 font-bold mb-0">All Teams</div>
                            @foreach($allTeams as $aTeam)
                                <button class="text-left p-1 rounded hover:bg-zinc-700 {{ $aTeam->id === $teamId ? 'bg-purple-200 dark:bg-purple-700' : '' }}" type="button" wire:click="showTeamProjects({{$aTeam->id}})">
                                    {{ $aTeam->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div x-data="{ open: false }">
                        <button class="text-left p-2 flex items-center" type="button" @click="open = !open">
                            <x-icon icon="caret-right" x-show="!open" class="h-4 w-4 mr-1" />
                            <x-icon icon="caret-down" x-show="open" class="h-4 w-4 mr-1" />
                            Show User's Projects
                        </button>
                        <div class="grid ml-4  border-l pl-3 max-h-[350px] overflow-y-scroll" x-show="open">
                            @if($usersOnYourTeams->count() > 0)
                                <div class="my-2 sticky top-0 dark:bg-zinc-700 bg-zinc-100 font-bold mb-0">Users on Your Teams</div>
                                @foreach($usersOnYourTeams as $teamUser)
                                    <button class="text-left p-1 rounded hover:bg-zinc-700 {{ $teamUser->id === $teamId ? 'bg-purple-200 dark:bg-purple-700' : '' }}" type="button" wire:click="showTeamProjects({{$teamUser->id}})">
                                        {{ $teamUser->name }}
                                    </button>
                                @endforeach
                            @endif
                            <div class="my-2 sticky top-0 dark:bg-zinc-700 bg-zinc-100 font-bold mb-0">All Users</div>
                            @foreach($allUsers as $alluser)
                                <button class="text-left p-1 rounded hover:bg-zinc-700 {{ $alluser->id === $teamId ? 'bg-purple-200 dark:bg-purple-700' : '' }}" type="button" wire:click="showTeamProjects({{$alluser->id}})">
                                    {{ $alluser->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
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
