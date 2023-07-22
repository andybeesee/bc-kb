<div class="mx-4 md:mx-10 lg:mx-12">
    <div class="button-tabs mb-4">
        <button
            wire:click.self="$set('tab', 'dashboard')"
            class="{{ $tab == 'dashboard' ? 'active' : '' }}"
            title="Show dashboard"
        >
            <x-icon icon="pie-chart-fill" class="h-4 w-4" />
            Dashboard
        </button>

        <button
            wire:click.self="$set('tab', 'list')"
            class="{{ $tab == 'list' ? 'active' : '' }}"
            title="Show Project List"
        >
            <x-icon icon="list" class="h-4 w-4" />
            Project List
        </button>

        <button type="button"
                wire:click.self="$set('tab', 'new')"
                class="{{ $tab == 'new' ? 'active' : '' }}"
                title="Start a New project"
        >
            <x-icon icon="plus-circle" class="h-4 w-4" />
            Start a New Project
        </button>
    </div>
    <div>
        @switch($tab)
            @case('dashboard')
                <x-project.dashboard :dashboard-data="$dashboardData" />
                @break
            @case('new')
                <livewire:project-form />
                @break
            @case('list')
                <div x-data="{ open: @entangle('filtersOpen') }">
                    <div class="mb-3 flex items-center">
                        <button
                            @click="open = !open"
                            title="Open filters"
                            class="flex items-center p-1 mr-3 rounded-md border border-zinc-400 hover:bg-zinc-100"
                            :class="open ? 'bg-indigo-700 text-white hover:bg-indigo-500' : 'bg-white hover:bg-zinc-200'"
                        >
                            <x-icon icon="sliders" class="h-6 w-6" />
                        </button>
                        <x-form.input
                            type="text" p
                            laceholder="Search"
                            class="p-1 w-full text-sm"
                            name="project_search"
                            placeholder="Search all projects"
                            wire:model="projectSearch"
                        />
                    </div>

                    <div class="md:items-start" :class="open ? 'grid md:grid-cols-4 gap-6' : 'grid'">
                        <div>
                            <div x-show="open">
                                <div class="grid mb-3">
                                    <div class="font-semibold mb-1 text-sm">Statuses to Show</div>
                                    @foreach($statusOptions as $statusValue => $statusName)
                                        <label class="py-1">
                                            <input
                                                type="checkbox"
                                                value="{{ $statusValue }}"
                                                wire:model="statusesToShow"
                                                name="statuses_to_show[]"
                                            />
                                            {{ $statusName }}
                                        </label>
                                    @endforeach
                                </div>
                                <div>
                                    <div class="font-semibold text-sm mb-1">Projects to Show</div>
                                    <div class="grid gap-1">
                                        <button type="button" class="w-full text-left rounded-md p-1 {{ $projectList === 'user' && $userId === auth()->user()->id ? 'bg-purple-200 dark:bg-purple-700' : 'hover:bg-zinc-300 dark:hover:bg-zinc-900' }}" wire:click="showUserProjects({{ auth()->user()->id }})">
                                            Your Projects
                                        </button>

                                        <button type="button" class="w-full text-left rounded-md p-1 {{ $projectList === 'team' && empty($teamId) ? 'bg-purple-200 dark:bg-purple-700' : 'hover:bg-zinc-300 dark:hover:bg-zinc-900' }}" wire:click="showTeamProjects(null)">
                                            Projects From Your Teams
                                        </button>

                                        <div x-data="{ open: false }">
                                            <button class="text-left p-1 flex items-center rounded-md w-full hover:bg-zinc-300 dark:hover:bg-zinc-900" type="button" @click="open = !open">
                                                <x-icon icon="caret-right" x-show="!open" class="h-4 w-4 mr-1" />
                                                <x-icon icon="caret-down" x-show="open" class="h-4 w-4 mr-1" />
                                                Your Teams
                                            </button>
                                            <div class="grid border-l pl-3 ml-4 max-h-[350px] overflow-y-scroll" x-show="open" style="display: none;">
                                                @foreach($userTeams as $uTeam)
                                                    <button
                                                        class="text-left p-1 rounded {{ $uTeam->id === $teamId ? 'bg-purple-200 dark:bg-purple-700' : 'hover:bg-zinc-200 dark:hover:bg-zinc-800' }}"
                                                        type="button"
                                                        wire:click="showTeamProjects({{$uTeam->id}})"
                                                    >
                                                        {{ $uTeam->name }}
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div><!-- end of your teams -->

                                        <div x-data="{ open: false }">
                                            <button class="text-left p-1 rounded-md flex w-full hover:bg-zinc-300 dark:hover:bg-zinc-900 items-center" type="button" @click="open = !open">
                                                <x-icon icon="caret-right" x-show="!open" class="h-4 w-4 mr-1" />
                                                <x-icon icon="caret-down" x-show="open" class="h-4 w-4 mr-1" />
                                                All Teams
                                            </button>
                                            <div class="grid border-l pl-3 ml-4 max-h-[350px] overflow-y-scroll" x-show="open" style="display: none;">
                                                @foreach($allTeams as $aTeam)
                                                    <button
                                                        class="text-left p-1 rounded {{ $aTeam->id === $teamId ? 'bg-purple-200 dark:bg-purple-700' : 'hover:bg-zinc-200 dark:hover:bg-zinc-800' }}"
                                                        type="button"
                                                        wire:click="showTeamProjects({{$aTeam->id}})"
                                                    >
                                                        {{ $aTeam->name }}
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div><!-- end of all teams -->

                                        <div x-data="{ open: false }">
                                            <button class="text-left p-1 items-center rounded-md flex w-full hover:bg-zinc-300 dark:hover:bg-zinc-900" type="button" @click="open = !open">
                                                <x-icon icon="caret-right" x-show="!open" class="h-4 w-4 mr-1" />
                                                <x-icon icon="caret-down" x-show="open" class="h-4 w-4 mr-1" />
                                                Users on Your Teams
                                            </button>
                                            <div class="grid ml-4  border-l pl-3 max-h-[350px] overflow-y-scroll" x-show="open" style="display: none;">
                                                @if($usersOnYourTeams->count() > 0)
                                                    @foreach($usersOnYourTeams as $teamUser)
                                                        <button
                                                            class="text-left p-1 rounded {{ $teamUser->id === $teamId ? 'bg-purple-200 dark:bg-purple-700' : 'hover:bg-zinc-200 dark:hover:bg-zinc-800' }}"
                                                            type="button"
                                                            wire:click="showTeamProjects({{$teamUser->id}})"
                                                        >
                                                            {{ $teamUser->name }}
                                                        </button>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div><!-- end of users on your teams -->

                                        <div x-data="{ open: false }">
                                            <button class="text-left p-1 flex items-center rounded-md flex w-full hover:bg-zinc-300 dark:hover:bg-zinc-900" type="button" @click="open = !open">
                                                <x-icon icon="caret-right" x-show="!open" class="h-4 w-4 mr-1" />
                                                <x-icon icon="caret-down" x-show="open" class="h-4 w-4 mr-1" />
                                                All Users
                                            </button>
                                            <div class="grid ml-4  border-l pl-3 max-h-[350px] overflow-y-scroll" x-show="open" style="display: none;">
                                                @foreach($allUsers as $alluser)
                                                    <button
                                                        class="text-left p-1 rounded {{ $alluser->id === $teamId ? 'bg-purple-200 dark:bg-purple-700' : 'hover:bg-zinc-200 dark:hover:bg-zinc-800' }}"
                                                        type="button"
                                                        wire:click="showTeamProjects({{$alluser->id}})"
                                                    >
                                                        {{ $alluser->name }}
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div><!-- end of all users -->
                                    </div><!-- end of team/user filters -->
                                </div>
                            </div>
                        </div><!--end of first column filters -->
                        <div class="col-span-3 grid divide-y dark:divide-zinc-600 divide-zinc-400">
                            @foreach($this->projects as $project)
                                <a
                                    href="{{ route('projects.show', $project->id) }}"
                                    class="cursor-pointer text-sm p-3 flex truncate items-center hover:bg-zinc-200 dark:hover:bg-zinc-700"
                                    title="{{ $project->name }} -- {{ $project->status }}"
                                >
                                    <span class=" mr-3 rounded-full bg-zinc-100 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300">
                                        <livewire:project-status-button wire:key="proj-stat-{{ $project->id }}-{{ $project->updated_at->getTimestamp() }}" :icon-only="true" icon-class="h-4 w-4" :project="$project" />
                                    </span>
                                    {{ $project->name }}

                                    <span class="flex ml-auto items-center space-x-2">
                                        @if($project->past_due_tasks_count > 0)
                                            <span class="text-red-700 dark:text-red-500">
                                                {{ $project->past_due_tasks_count }} Late Task{{ $project->past_due_tasks_count !== 1 ? 's' : '' }}
                                            </span>
                                        @endif
                                        @if($project->incomplete_tasks_count > 0)
                                            <span>
                                                {{ $project->incomplete_tasks_count }} Open Task{{ $project->incomplete_tasks_count !== 1 ? 's' : '' }}
                                            </span>
                                        @endif
                                        <span class="pl-3">
                                            <x-icon icon="chevron-right" class="h-3 w-3" />
                                        </span>
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div><!-- end of list -->
                @break
        @endswitch
    </div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
</div>
