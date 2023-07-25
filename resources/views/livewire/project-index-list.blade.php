<div x-data="{ open: @entangle('filtersOpen') }">
    <div class="mb-3 flex items-center">
        <button
            @click="open = !open"
            title="Open filters"
            class="flex items-center p-1 mr-3 rounded-md border border-zinc-400 hover:bg-zinc-100"
            :class="open ? 'bg-indigo-700 text-white hover:bg-indigo-800' : 'bg-white dark:bg-zinc-900 hover:bg-zinc-200 dark:hover:bg-zinc-700'"
        >
            <x-icon icon="sliders" class="h-6 w-6" />
        </button>
        <x-form.input
            type="text"
            laceholder="Search"
            class="p-1 w-full text-sm"
            name="project_search"
            placeholder="Search all projects"
            wire:model="projectSearch"
        />
    </div>

    <div class="md:items-start" :class="open ? 'grid md:grid-cols-4 gap-6' : 'grid'">
        <div x-show="open">
            <div>
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
                    @php
                        $btnNormalClass = 'hover:bg-zinc-300 dark:hover:bg-zinc-900';
                        $btnActiveClass = 'bg-purple-100 hover:bg-purple-300 dark:bg-purple-700 dark:hover:bg-purple-900';
                    @endphp
                    <div class="font-semibold text-sm mb-1">Projects to Show</div>
                    <div class="grid gap-1">
                        <button
                            type="button"
                            class="w-full text-left rounded-md p-1 {{ $filterType === 'current_user' ? $btnActiveClass : $btnNormalClass }}"
                            wire:click="setFilter('current_user')"
                        >
                            Your Projects
                        </button>

                        <button
                            type="button"
                            class="w-full text-left rounded-md p-1 {{ $filterType === 'current_user_teams' ? $btnActiveClass : $btnNormalClass }}"
                            wire:click="setFilter('current_user_teams')"
                        >
                            Projects From Your Teams
                        </button>

                        <div x-data="{ open: false }">
                            <button
                                class="{{ $filterType === 'user_team' ? $btnActiveClass : $btnNormalClass }} text-left p-1 flex items-center rounded-md w-full"
                                type="button"
                                @click="open = !open"
                            >
                                <x-icon icon="caret-right" x-show="!open" class="h-4 w-4 mr-1" />
                                <x-icon icon="caret-down" x-show="open" class="h-4 w-4 mr-1" />
                                Your Teams
                            </button>
                            <div class="grid border-l pl-3 ml-4 max-h-[350px] overflow-y-scroll" x-show="open" style="display: none;">
                                @foreach($userTeams as $uTeam)
                                    <button
                                        class="text-left p-1 rounded {{ $filterType === 'user_team' && $filterId === $uTeam->id ? $btnActiveClass : 'hover:bg-zinc-200 dark:hover:bg-zinc-800' }}"
                                        type="button"
                                        wire:click="setFilter('user_team', {{$uTeam->id}})"
                                    >
                                        {{ $uTeam->name }}
                                    </button>
                                @endforeach
                            </div>
                        </div><!-- end of your teams -->

                        <div x-data="{ open: false }">
                            <button class="text-left p-1 rounded-md flex w-full {{ $filterType === 'all_team' ? $btnActiveClass : $btnNormalClass }} items-center" type="button" @click="open = !open">
                                <x-icon icon="caret-right" x-show="!open" class="h-4 w-4 mr-1" />
                                <x-icon icon="caret-down" x-show="open" class="h-4 w-4 mr-1" />
                                All Teams
                            </button>
                            <div class="grid border-l pl-3 ml-4 max-h-[350px] overflow-y-scroll" x-show="open" style="display: none;">
                                @foreach($allTeams as $aTeam)
                                    <button
                                        class="text-left p-1 rounded {{ $filterType === 'all_team' && $filterId === $aTeam->id ? $btnActiveClass : $btnNormalClass }}"
                                        type="button"
                                        wire:click="setFilter('all_team', {{$aTeam->id}})"
                                    >
                                        {{ $aTeam->name }}
                                    </button>
                                @endforeach
                            </div>
                        </div><!-- end of all teams -->

                        <div x-data="{ open: false }">
                            <button class="text-left p-1 items-center rounded-md flex w-full {{ $filterType === 'team_user' ? $btnActiveClass : $btnNormalClass }}" type="button" @click="open = !open">
                                <x-icon icon="caret-right" x-show="!open" class="h-4 w-4 mr-1" />
                                <x-icon icon="caret-down" x-show="open" class="h-4 w-4 mr-1" />
                                Users on Your Teams
                            </button>
                            <div class="grid ml-4  border-l pl-3 max-h-[350px] overflow-y-scroll" x-show="open" style="display: none;">
                                @if($usersOnYourTeams->count() > 0)
                                    @foreach($usersOnYourTeams as $teamUser)
                                        <button
                                            class="text-left p-1 rounded {{ $filterType === 'team_user' && $filterId === $teamUser->id ? 'bg-purple-200 dark:bg-purple-700' : 'hover:bg-zinc-200 dark:hover:bg-zinc-800' }}"
                                            type="button"
                                            wire:click="setFilter('team_user', {{$teamUser->id}})"
                                        >
                                            {{ $teamUser->name }}
                                        </button>
                                    @endforeach
                                @endif
                            </div>
                        </div><!-- end of users on your teams -->

                        <div x-data="{ open: false }">
                            <button class="text-left p-1 flex items-center rounded-md w-full {{ $filterType === 'all_user' ? $btnActiveClass : $btnNormalClass }}" type="button" @click="open = !open">
                                <x-icon icon="caret-right" x-show="!open" class="h-4 w-4 mr-1" />
                                <x-icon icon="caret-down" x-show="open" class="h-4 w-4 mr-1" />
                                All Users
                            </button>
                            <div class="grid ml-4  border-l pl-3 max-h-[350px] overflow-y-scroll" x-show="open" style="display: none;">
                                @foreach($allUsers as $alluser)
                                    <button
                                        class="text-left p-1 rounded {{ $filterType === 'all_user' && $filterId === $alluser->id ? $btnActiveClass : $btnNormalClass }}"
                                        type="button"
                                        wire:click="setFilter('all_user', {{$alluser->id}})"
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
                <div
                    class="cursor-pointer text-sm p-3 flex items-center hover:bg-zinc-200 dark:hover:bg-zinc-700"
                    title="{{ $project->name }} -- {{ $project->status }}"
                    @click="window.location.href = '{{ route('projects.show', $project->id) }}'"
                >
                    <div class="flex items-start w-full">
                        <div class="mr-3 mt-1 rounded-full bg-zinc-100 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300">
                            <livewire:project-status-button wire:key="proj-stat-{{ $project->id }}-{{ $project->updated_at->getTimestamp() }}" :icon-only="true" icon-class="h-4 w-4" :project="$project" />
                        </div>
                        <div class="flex-grow">
                            <div class="flex items-start w-full">
                                <div class="flex items-center">
                                    <div x-data="{menuOpen: false}" class="relative">
                                        <button @click.stop="menuOpen = true" type="button" class="pt-1 mr-2 hover:bg-zinc-200 hover:dark:bg-zinc-900 rounded-full">
                                            <x-icon icon="three-dots-vertical" class="h-4 w-4" />
                                        </button>
                                        <div @click.outside="menuOpen = false" x-show="menuOpen" class="min-w-[150px] absolute grid z-[100] rounded-md bg-white dark:bg-zinc-800 border border-zinc-500" style="display: none;">
                                            <button type="button" class="p-2 text-left hover:bg-zinc-300 dark:hover:bg-zinc-900" href="#">Edit Project</button>
                                            <button type="button" class="p-2 text-left hover:bg-zinc-300 dark:hover:bg-zinc-900" href="#">Add an Update</button>
                                            <button type="button" class="p-2 text-left hover:bg-zinc-300 dark:hover:bg-zinc-900" href="#">Change Due Date</button>
                                            <button type="button" class="p-2 text-left hover:bg-zinc-300 dark:hover:bg-zinc-900" href="#">Change Status</button>
                                            <button type="button" class="p-2 text-left hover:bg-zinc-300 dark:hover:bg-zinc-900" href="#">Change Owner</button>
                                        </div>
                                    </div>
                                    <div class="font-semibold">
                                        {{ $project->name }}
                                    </div>

                                </div>
                                <div class="ml-auto flex items-center space-x-3">
                                    @if($project->past_due_tasks_count > 0)
                                        <div class="text-red-700 dark:text-red-500">
                                            {{ $project->past_due_tasks_count }} Late Task{{ $project->past_due_tasks_count !== 1 ? 's' : '' }}
                                        </div>
                                    @endif
                                    @if($project->incomplete_tasks_count > 0)
                                        <div>
                                            {{ $project->incomplete_tasks_count }} Open Task{{ $project->incomplete_tasks_count !== 1 ? 's' : '' }}
                                        </div>
                                    @endif
                                    <div>
                                        <x-icon icon="chevron-right" class="h-3 w-3" />
                                    </div>
                                </div>
                            </div>
                            <div class="text-xs mt-1 flex items-center space-x-4 text-zinc-500 dark:text-zinc-400">
                                @if($project->due_date)
                                    {{-- TODO: inline due date change? --}}
                                    <div class="{{ $project->isLate ? 'text-red-600' : '' }}">
                                        Due {{ $project->due_date->format(config('app.date_display')) }}
                                    </div>
                                @endif
                                <div>
                                    {{-- TODO: Inline last update change, def --}}
                                    Last update on xxxx by username: some tet goeshad asdkjl
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
