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
                                wire:model.live="statusesToShow"
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
                    class="cursor-pointer text-sm p-3 hover:bg-zinc-200 dark:hover:bg-zinc-700"
                    title="{{ $project->name }} -- {{ $project->status }}"
                    @click="window.location.href = '{{ route('projects.show', $project->id) }}'"
                >
                    <livewire:project-list-item
                        :project="$project"
                        :key="'proj-lind-lis-it-'.$project->id"
                    />
                </div>
            @endforeach
        </div>
    </div>
</div>
