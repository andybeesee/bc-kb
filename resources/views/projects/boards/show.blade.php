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
                        class="px-1 truncate rounded-md {{ $project->id === $sideProject->id ? 'bg-purple-300 hover:bg-purple-400 dark:hover:bg-purple-900 dark:bg-purple-700' : 'hover:bg-zinc-200 dark:hover:bg-zinc-600' }}"
                        title="{{ $sideProject->name }}"
                        href="{{ route('projects.show', $sideProject->id) }}"
                        {{ $project->id === $sideProject->id ? 'data-scroll-into-view=1' : '' }}
                    >
                        {{ $sideProject->name }}
                    </a>
                @endforeach
            </div>
        </div>
        <div class="full-body-scroll-column">
            <div class="mb-2">
                <div class="mb-1 font-semibold">Project Boards</div>
                <input type="text" class="form-control form-control-sm" placeholder="Search Boards on this Project" />
            </div>
            <div class="grid" hx-boost="true">
                @foreach($project->boards as $projectBoard)
                        <a
                            href="{{ route('projects.boards.show', [$project->id, $projectBoard->id]) }}"
                            title="{{ $projectBoard->name }}"
                            class="{{ $loop->last ? '' : 'mb-1' }} p-1 rounded-md truncate {{ $projectBoard->id === $board->id ? 'bg-purple-300 hover:bg-purple-400 dark:hover:bg-purple-900 dark:bg-purple-700' : 'hover:bg-zinc-200 dark:hover:bg-zinc-600' }}"
                            {{ $projectBoard->id === $board->id ? 'data-scroll-into-view=1' : '' }}
               >
                   <span>{{ $projectBoard->name }}</span>
                            <br>
                            @include('boards._count-box', ['board' => $projectBoard])
                        </a>
                @endforeach
            </div>
        </div>
        <div class="col-span-3 full-body-scroll-column h-full">
            <div class="font-semibold mb-3">Board: {{ $board->name }}</div>
            <div class="">
                comments, files, tasks on board all that jazz goes here in a scrolling way
            </div>
        </div>
    </div>
</x-app-layout>
