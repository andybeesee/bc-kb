<x-app-layout title="Baord detail">
    <div class="items-start grid grid-cols-5 gap-4 mx-5 overflow-x-hidden">
        {{--TODO: we want the columns full availavle height with scrolling --}}
        {{-- TODO: we need to calculate max height and do ti that way? --}}
        {{--TODO: scroll in to view, or dosomething with Turbo? --}}
        <div class="full-body-scroll-column">
            <div class="mb-2">
                <div class="mb-1 font-semibold">Your Projects</div>
                <input type="text" class="form-control form-control-sm" placeholder="Search Projects" />
            </div>

            <div class="grid" hx-boost="true">
                @php $userProjects = \App\Models\Project::forUser(auth()->user())->orderBy('name')->get(); @endphp
                @foreach($userProjects as $sideProject)
                    <a
                        hx-get="{{ route('projects.show', $sideProject->id) }}"
                        hx-target="#project-board-list"
                        hx-select="#project-board-list"
                        hx-swap="outerHTML"
                        hx-push-url="true"
                        class="px-1 truncate rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-600"
                        title="{{ $sideProject->name }}"
                        {{--TODO: if we do this business we need to update active class somehow --}}
                        data-active-class="bg-purple-300 cursor-pointer hover:bg-purple-400 dark:hover:bg-purple-900 dark:bg-purple-700"
                        data-inactive-class="hover:bg-zinc-200 dark:hover:bg-zinc-600"
                        href="{{ route('projects.show', $sideProject->id) }}/"
                        {{ $project->id === $sideProject->id ? 'data-scroll-into-view=1' : '' }}
                    >
                        {{ $sideProject->name }}
                    </a>
                @endforeach
            </div>
        </div>
        <div class="col-span-3 grid grid-cols-4 gap-4" id="project-board-list">
            <div class="full-body-scroll-column">
                <div class="mb-2">
                    <div class="mb-1 font-semibold">Project Boards</div>
                    <input type="text" class="form-control form-control-sm" placeholder="Search Boards on this Project" />
                </div>
                <div class="grid" hx-boost="true">
                    @foreach($project->boards as $projectBoard)
                        {{--TODO: On click updated the url --}}
                        <a
                            href="{{ route('projects.boards.show', [$project->id, $projectBoard->id]) }}"
                            hx-get="{{ route('projects.boards.show', [$project->id, $projectBoard->id]) }}"
                            hx-target="#board-detail"
                            hx-swap="outerHTML"
                            hx-select="#board-detail"
                            hx-push-url="true"
                            title="{{ $projectBoard->name }}"
                            data-active-class="bg-purple-300 hover:bg-purple-400 dark:hover:bg-purple-900 dark:bg-purple-700"
                            data-inactive-class="hover:bg-zinc-200 dark:hover:bg-zinc-600"
                            class="{{ $loop->last ? '' : 'mb-1' }} p-1 rounded-md truncate"
                            {{ $projectBoard->id === $board->id ? 'data-scroll-into-view=1' : '' }}
                        >
                            <span>{{ $projectBoard->name }}</span>
                            <br>
                            @include('boards._count-box', ['board' => $projectBoard])
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="col-span-3 full-body-scroll-column h-full" id="board-detail">
                <div class="font-semibold mb-3">Board: {{ $board->name }}</div>
                <div class="">
                    comments, files, tasks on board all that jazz goes here in a scrolling way
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
