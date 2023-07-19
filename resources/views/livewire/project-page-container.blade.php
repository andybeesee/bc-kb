<div class="mx-1 md:mx-6 lg:mx-10 grid grid-cols-5 gap-8 items-start">
    <div>
        <div class="grid">
            <div class="mb-3">
                <x-form.input
                    type="text" p
                    laceholder="Search"
                    class="p-1 text-sm"
                    name="project_search"
                    placeholder="Search all projects"
                    wire:model="projectSearch"
                />
            </div>

            <button
                wire:click.self="showDashboard"
                class="w-full cursor-pointer text-sm p-2 flex truncate items-center rounded-md {{ empty($projectId) && !$newProject ? 'bg-purple-100 dark:bg-purple-700 hover:bg-purple-200 dark:hover:bg-purple-800' : 'hover:bg-zinc-100 hover:bg-zinc-700' }}"
                title="Show dashboard"
            >
                <div class=" mr-3 rounded-full bg-zinc-100 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300">
                    <x-icon icon="pie-chart-fill" class="h-4 w-4" />
                </div>
                Dashboard
            </button>

            <button type="button"
                    wire:click="openNewProjectForm"
                    class="cursor-pointer text-sm p-2 flex truncate items-center rounded-md {{ $newProject === true ? 'bg-purple-100 dark:bg-green-700 hover:bg-green-200 dark:hover:bg-green-800' : 'hover:bg-green-100 dark:hover:bg-green-700' }}"
                    title="Start a New project"
            >
                <div class="mr-3 rounded-full bg-zinc-100 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300">
                    <x-icon icon="plus-circle" class="h-4 w-4" />
                </div>
                Start a New Project
            </button>

            <div x-data="{ open: false }">
                <button type="button" class="p-2 text-left flex items-center text-sm" @click="open = !open">
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
                    wire:click.self="showProject({{$project->id}})"
                    class="cursor-pointer text-sm p-2 flex truncate items-center rounded-md {{ $project->id === $projectId ? 'bg-purple-100 dark:bg-purple-700 hover:bg-purple-200 dark:hover:bg-purple-800' : 'hover:bg-zinc-100 hover:bg-zinc-700' }}"
                    title="{{ $project->name }} -- {{ $project->status }}"
                >
                    <div class=" mr-3 rounded-full bg-zinc-100 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300">
                        <livewire:project-status-button wire:key="proj-stat-{{ $project->id }}-{{ $project->updated_at->getTimestamp() }}" :icon-only="true" icon-class="h-4 w-4" :project="$project" />
                    </div>
                    {{ $project->name }}
                </button>
            @endforeach
        </div>
    </div>
    <div class="col-span-3">
        @if(empty($projectId))
            @if($newProject)
                <livewire:project-form />
            @else
                <x-project.dashboard :dashboard-data="$dashboardData" />
            @endif
        @else
            <livewire:project-detail-page :project-id="$projectId" wire:key="container-project-detail-{{ $projectId }}" />
        @endif
    </div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
</div>
